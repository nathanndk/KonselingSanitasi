<?php

namespace App\Filament\Widgets;

use App\Models\PDAM;
use App\Models\SanitationCondition;
use App\Models\HousingSurvey;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TotalReportLineChart extends ChartWidget
{
    // Judul widget
    protected static ?string $heading = null;

    protected static bool $isLazy = true;

    protected static ?int $sort = 1;

    // Ubah akses metode ini menjadi public untuk menampilkan judul
    public function getHeading(): string
    {
        return 'Total Laporan ' . Carbon::now()->year . '';
    }

    /**
     * Metode ini membatasi widget hanya dapat dilihat oleh role tertentu
     */
    public static function canView(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // Daftar role yang diperbolehkan
        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }

    /**
     * Fungsi untuk menerapkan filter role ke dalam query builder
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyRoleFilter($query)
    {
        $user = Auth::user();

        // Jika tidak ada user atau role tidak dikenali, kembalikan query yang tidak menghasilkan data
        if (!$user) {
            return $query->where('id', -1);
        }

        switch ($user->role) {
            case 'admin':
            case 'dinas_kesehatan':
                // Admin & Dinkes melihat semua data => tidak ada filter tambahan
                break;

            case 'puskesmas':
                // Hanya data yang terkait puskesmas user
                // Asumsikan ada relasi user->healthCenter
                $query->whereHas('user.healthCenter', function ($q) use ($user) {
                    $q->where('id', $user->health_center_id);
                });
                break;

            case 'petugas':
            case 'kader':
                // Hanya data yang dibuat oleh user tersebut
                // Asumsikan ada kolom `created_by` di tabel
                $query->where('created_by', $user->id);
                break;

            default:
                // Role lain => tidak boleh akses apa-apa
                $query->where('id', -1);
                break;
        }

        return $query;
    }

    // Fungsi untuk mendapatkan data yang akan ditampilkan di grafik
    protected function getData(): array
    {
        // Inisialisasi array kosong untuk setiap kategori laporan (12 bulan)
        $laporanBulananPDAM = array_fill(0, 12, 0);
        $laporanBulananSanitasi = array_fill(0, 12, 0);
        $laporanBulananRumahSehat = array_fill(0, 12, 0);

        $tahunSekarang = Carbon::now()->year;

        // 1. Query PDAM: terapkan role filter, lalu hitung jumlah per bulan
        $laporanPDAM = $this->applyRoleFilter(
            PDAM::query()
        )
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // 2. Query Konseling Sanitasi: terapkan role filter, lalu hitung jumlah per bulan
        $laporanSanitasi = $this->applyRoleFilter(
            SanitationCondition::query()
        )
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // 3. Query Rumah Sehat: terapkan role filter, lalu hitung jumlah per bulan
        $laporanRumahSehat = $this->applyRoleFilter(
            HousingSurvey::query()
        )
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // Pemetaan hasil query ke array indeks bulanan (0-11)
        foreach ($laporanPDAM as $laporan) {
            $laporanBulananPDAM[$laporan->bulan - 1] = (int) $laporan->jumlah;
        }

        foreach ($laporanSanitasi as $laporan) {
            $laporanBulananSanitasi[$laporan->bulan - 1] = (int) $laporan->jumlah;
        }

        foreach ($laporanRumahSehat as $laporan) {
            $laporanBulananRumahSehat[$laporan->bulan - 1] = (int) $laporan->jumlah;
        }

        // Data untuk grafik
        return [
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            'datasets' => [
                [
                    'label' => 'Laporan PDAM',
                    'data' => $laporanBulananPDAM,
                    'borderColor' => '#2196f3',
                    'backgroundColor' => 'rgba(33, 150, 243, 0.2)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Konseling Sanitasi',
                    'data' => $laporanBulananSanitasi,
                    'borderColor' => '#4caf50',
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Laporan Rumah Sehat',
                    'data' => $laporanBulananRumahSehat,
                    'borderColor' => '#f44336',
                    'backgroundColor' => 'rgba(244, 67, 54, 0.2)',
                    'tension' => 0.4,
                ],
            ],
            'options' => [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true,
                                'suggestedMin' => 0,
                                'stepSize' => 1,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    // Jenis grafik yang digunakan
    protected function getType(): string
    {
        return 'line'; // Jenis grafik: garis
    }
}
