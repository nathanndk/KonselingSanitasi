<?php

namespace App\Filament\Resources\HouseResource\Widgets;

use App\Models\HousingSurvey;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HouseStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total laporan rumah sehat
        $totalReports = HousingSurvey::count();

        // Ambang batas untuk menentukan MS/TMS
        $threshold = 75;

        // Perhitungan MS/TMS untuk Rumah Layak
        $totalHousesMS = HousingSurvey::where(function ($query) {
            $query->where('roof_strong_no_leak', 1)
                ->where('roof_drainage', 1)
                ->where('ceiling_strong_safe', 1)
                ->where('ceiling_clean_no_dust', 1)
                ->where('ceiling_flat_adequate_air', 1)
                ->where('ceiling_clean_condition', 1);
        })->count();

        $totalHousesTMS = $totalReports - $totalHousesMS;

        // Perhitungan MS/TMS untuk Sanitasi
        $totalSanitationMS = HousingSurvey::where(function ($query) {
            $query->where('safe_drinking_water_source', 1)
                ->where('drinking_water_location', 1)
                ->where('toilet_usage', 1)
                ->where('own_toilet', 1)
                ->where('ctps_facility', 1)
                ->where('ctps_accessibility', 1);
        })->count();

        $totalSanitationTMS = $totalReports - $totalSanitationMS;

        // Perhitungan MS/TMS untuk Perilaku
        $totalBehaviorMS = HousingSurvey::where(function ($query) {
            $query->where('bedroom_window_open', 1)
                ->where('living_room_window_open', 1);
        })->count();

        $totalBehaviorTMS = $totalReports - $totalBehaviorMS;

        // Perhitungan Hasil Sanitarian Kit
        $totalSanitarianKitMS = HousingSurvey::where(function ($query) {
            $query->where('noise_level', 1)
                ->where('humidity', 1);
        })->count();

        $totalSanitarianKitTMS = $totalReports - $totalSanitarianKitMS;

        // Perhitungan skor keseluruhan
        $overallScores = $totalHousesMS + $totalSanitationMS + $totalBehaviorMS + $totalSanitarianKitMS;
        $averageScore = $totalReports > 0 ? ($overallScores / ($totalReports * 4)) * 100 : 0;

        $finalStatus = $averageScore >= $threshold ? 'MS' : 'TMS';

        return [
            Stat::make('Total Laporan Rumah Sehat', $totalReports)
                ->description('Jumlah total laporan rumah sehat')
                ->descriptionIcon('heroicon-o-home')
                ->color('success'),

            Stat::make('Rumah Layak', $totalHousesMS)
                ->description("MS: {$totalHousesMS} | TMS: {$totalHousesTMS}")
                ->descriptionIcon('heroicon-o-home')
                ->color('primary'),

            Stat::make('Sanitasi', $totalSanitationMS)
                ->description("MS: {$totalSanitationMS} | TMS: {$totalSanitationTMS}")
                ->descriptionIcon('heroicon-o-home')
                ->color('info'),

            Stat::make('Perilaku', $totalBehaviorMS)
                ->description("MS: {$totalBehaviorMS} | TMS: {$totalBehaviorTMS}")
                ->descriptionIcon('heroicon-o-user')
                ->color('warning'),

            Stat::make('Hasil Sanitarian Kit', $totalSanitarianKitMS)
                ->description("MS: {$totalSanitarianKitMS} | TMS: {$totalSanitarianKitTMS}")
                ->descriptionIcon('heroicon-o-home')
                ->color('secondary'),

            Stat::make('Status Keseluruhan', $finalStatus)
                ->description("Skor Rata-rata: " . number_format($averageScore, 2) . '%')
                ->descriptionIcon('heroicon-o-check')
                ->color($finalStatus === 'MS' ? 'success' : 'danger'),
        ];
    }
}
