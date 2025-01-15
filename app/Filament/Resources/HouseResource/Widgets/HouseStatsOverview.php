<?php

namespace App\Filament\Resources\HouseResource\Widgets;

use App\Models\HousingSurvey;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class HouseStatsOverview extends BaseWidget
{
    /**
     * Filter query sesuai role user
     */
    private function applyRoleFilter($query)
    {
        $user = Auth::user();

        // Jika user tidak ada atau role tidak dikenali, kembalikan query yang menghasilkan 0 data
        if (!$user) {
            return $query->where('id', -1);
        }

        switch ($user->role) {
            case 'admin':
            case 'dinas_kesehatan':
                // Admin & Dinas Kesehatan melihat semua data => tidak ada filter tambahan
                break;

            case 'puskesmas':
                // Hanya data di puskesmas user terkait
                $query->whereHas('user.healthCenter', function ($q) use ($user) {
                    $q->where('id', $user->health_center_id);
                });
                break;

            case 'petugas':
            case 'kader':
                // Hanya data yang dibuat oleh user
                $query->where('created_by', $user->id);
                break;

            default:
                // Role lain, tidak boleh akses data
                $query->where('id', -1);
                break;
        }

        return $query;
    }

    protected function getStats(): array
    {
        /**
         * Di bawah ini contoh cara melakukan perhitungan
         * dengan memanfaatkan query yang sudah difilter oleh applyRoleFilter().
         */

        // ========== 1. TOTAL LAPORAN RUMAH SEHAT ==========
        $totalReports = $this->applyRoleFilter(
            HousingSurvey::query()
        )->count();

        // ========== 2. PARAMETER LAINNYA (Syarat Rumah Layak) ==========
        // Base query untuk "Rumah Layak" (MS / TMS)
        $houseLayakMSQuery = $this->applyRoleFilter(
            HousingSurvey::query()
        )->where(function ($query) {
            $query->where('roof_strong_no_leak', 1)
                ->where('roof_drainage', 1)
                ->where('ceiling_strong_safe', 1)
                ->where('ceiling_clean_no_dust', 1)
                ->where('ceiling_flat_adequate_air', 1)
                ->where('ceiling_clean_condition', 1);
        });
        $totalHousesMS = $houseLayakMSQuery->count();
        $totalHousesTMS = $totalReports - $totalHousesMS;

        // ========== 3. PARAMETER SANITASI (MS / TMS) ==========
        $sanitationMSQuery = $this->applyRoleFilter(
            HousingSurvey::query()
        )->where(function ($query) {
            $query->where('safe_drinking_water_source', 1)
                ->where('drinking_water_location', 1)
                ->where('toilet_usage', 1)
                ->where('own_toilet', 1)
                ->where('ctps_facility', 1)
                ->where('ctps_accessibility', 1);
        });
        $totalSanitationMS = $sanitationMSQuery->count();
        $totalSanitationTMS = $totalReports - $totalSanitationMS;

        // ========== 4. PARAMETER PERILAKU (MS / TMS) ==========
        $behaviorMSQuery = $this->applyRoleFilter(
            HousingSurvey::query()
        )->where(function ($query) {
            $query->where('bedroom_window_open', 1)
                ->where('living_room_window_open', 1);
        });
        $totalBehaviorMS = $behaviorMSQuery->count();
        $totalBehaviorTMS = $totalReports - $totalBehaviorMS;

        // ========== 5. HASIL SANITARIAN KIT (MS / TMS) ==========
        // Silakan isi kriteria sesuai data sanitariannya
        // Misal: humidity, temperature, dsb.
        $sanitarianKitMSQuery = $this->applyRoleFilter(
            HousingSurvey::query()
        )->where(function ($query) {
            // Contoh kriteria: humidity harus < 60% (kondisional)
            // $query->where('humidity', '<=', 60)
            //       ->where('co2_level', '<=', 1000);
            //
            // Sesuaikan dengan kondisi real di database
        });
        $totalSanitarianKitMS = $sanitarianKitMSQuery->count();
        $totalSanitarianKitTMS = $totalReports - $totalSanitarianKitMS;

        // ========== 6. HITUNG SKOR & STATUS AKHIR (MS / TMS) ==========
        // Misal kita asumsikan tiap komponen punya bobot yang sama
        $overallScores = $totalHousesMS + $totalSanitationMS + $totalBehaviorMS + $totalSanitarianKitMS;
        $averageScore  = $totalReports > 0
            ? ($overallScores / ($totalReports * 4)) * 100
            : 0;

        // Threshold contoh = 75
        $threshold    = 75;
        $finalStatus  = $averageScore >= $threshold ? 'MS' : 'TMS';

        // ========== 7. RETURN STATS ==========
        return [
            Stat::make('Total Laporan Rumah Sehat', $totalReports)
                ->description('Jumlah total laporan rumah sehat')
                ->descriptionIcon('heroicon-o-document-text'),

            Stat::make('Rumah Layak', $totalHousesMS)
                ->description("MS: {$totalHousesMS} | TMS: {$totalHousesTMS}"),

            Stat::make('Sanitasi', $totalSanitationMS)
                ->description("MS: {$totalSanitationMS} | TMS: {$totalSanitationTMS}"),

            Stat::make('Perilaku', $totalBehaviorMS)
                ->description("MS: {$totalBehaviorMS} | TMS: {$totalBehaviorTMS}"),

            Stat::make('Hasil Sanitarian Kit', $totalSanitarianKitMS)
                ->description("MS: {$totalSanitarianKitMS} | TMS: {$totalSanitarianKitTMS}"),

            Stat::make('Status Keseluruhan', $finalStatus)
                ->description("Skor Rata-rata: " . number_format($averageScore, 2) . '%')
                ->color($finalStatus === 'MS' ? 'success' : 'danger'),
        ];
    }

    /**
     * Batasi widget hanya muncul untuk role tertentu
     */
    public static function canView(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }
}
