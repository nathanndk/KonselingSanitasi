<?php

namespace App\Filament\Widgets;

use App\Models\Pdam;
use App\Models\SanitationCondition;
use App\Models\HousingSurvey;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PuskesmasStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil total jumlah pasien tanpa filter berdasarkan health_center_id
        $totalPatients = Patient::count();

        // Mengambil laporan PDAM yang terkait dengan pasien (tanpa filter berdasarkan health_center_id)
        $totalPdamReports = Pdam::whereHas('patient')->count();

        // Mengambil laporan konseling sanitasi yang terkait dengan pasien (tanpa filter berdasarkan health_center_id)
        $totalSanitationCounselingReports = SanitationCondition::whereHas('patient')->count();

        // Mengambil laporan rumah sehat yang terkait dengan pasien (tanpa filter berdasarkan health_center_id)
        $totalHealthyHomeReports = HousingSurvey::whereHas('patient')->count();

        return [
            Stat::make('Total Pasien', $totalPatients)
                ->description('Total pasien terdaftar di sistem')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Total Laporan PDAM', $totalPdamReports)
                ->description('Total laporan PDAM terkait pasien')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Total Konseling Sanitasi', $totalSanitationCounselingReports)
                ->description('Total laporan Konseling Sanitasi terkait pasien')
                ->descriptionIcon('heroicon-o-clipboard')
                ->color('warning'),

            Stat::make('Total Rumah Sehat', $totalHealthyHomeReports)
                ->description('Total laporan Rumah Sehat terkait pasien')
                ->descriptionIcon('heroicon-o-home')
                ->color('info'),
        ];
    }

    public static function canView(): bool
    {
        // Hanya izinkan pengguna dengan peran 'Puskesmas' untuk melihat widget ini
        return Auth::check() && Auth::user()->hasRole('Puskesmas');
    }
}
