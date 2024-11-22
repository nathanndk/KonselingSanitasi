<?php

namespace App\Filament\Widgets;

use App\Models\PDAM;
use App\Models\SanitationCondition;
use App\Models\HousingSurvey;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

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

    // Fungsi untuk mendapatkan data yang akan ditampilkan di grafik
    protected function getData(): array
    {
        // Inisialisasi array kosong untuk setiap kategori laporan (12 bulan)
        $laporanBulananPDAM = array_fill(0, 12, 0);
        $laporanBulananSanitasi = array_fill(0, 12, 0);
        $laporanBulananRumahSehat = array_fill(0, 12, 0);
        $tahunSekarang = Carbon::now()->year;

        // Query untuk menghitung laporan PDAM berdasarkan bulan
        $laporanPDAM = PDAM::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // Query untuk menghitung laporan Konseling Sanitasi berdasarkan bulan
        $laporanSanitasi = SanitationCondition::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // Query untuk menghitung laporan Rumah Sehat berdasarkan bulan
        $laporanRumahSehat = HousingSurvey::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('bulan')
            ->get();

        // Pemetaan hasil query ke array masing-masing bulan
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
            ], // Label bulan
            'datasets' => [
                [
                    'label' => 'Laporan PDAM', // Label dataset
                    'data' => $laporanBulananPDAM, // Data laporan bulanan PDAM
                    'borderColor' => '#2196f3', // Warna garis
                    'backgroundColor' => 'rgba(33, 150, 243, 0.2)', // Warna latar bawah garis
                    'tension' => 0.4, // Membuat garis lebih halus
                ],
                [
                    'label' => 'Konseling Sanitasi', // Label dataset
                    'data' => $laporanBulananSanitasi, // Data laporan bulanan Konseling Sanitasi
                    'borderColor' => '#4caf50', // Warna garis
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)', // Warna latar bawah garis
                    'tension' => 0.4, // Membuat garis lebih halus
                ],
                [
                    'label' => 'Laporan Rumah Sehat', // Label dataset
                    'data' => $laporanBulananRumahSehat, // Data laporan bulanan Rumah Sehat
                    'borderColor' => '#f44336', // Warna garis
                    'backgroundColor' => 'rgba(244, 67, 54, 0.2)', // Warna latar bawah garis
                    'tension' => 0.4, // Membuat garis lebih halus
                ],
            ],
            'options' => [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true, // Skala Y dimulai dari 0
                                'suggestedMin' => 0, // Pastikan tidak ada nilai negatif
                                'stepSize' => 1, // Skala Y berupa bilangan bulat
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
