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
        $user = Auth::user();
        $healthCenterId = $user->health_center_id; // Dapatkan `health_center_id` pengguna yang sedang login

        // Hitung jumlah pasien yang berada di puskesmas pengguna yang sedang login
        $totalPatients = Patient::where('health_center_id', $healthCenterId)->count();

        // Hanya ambil laporan yang terkait dengan `health_center_id` melalui `patient_id`
        $totalPdamReports = Pdam::whereHas('patient', function ($query) use ($healthCenterId) {
            $query->where('health_center_id', $healthCenterId);
        })->count();

        $totalSanitationCounselingReports = SanitationCondition::whereHas('patient', function ($query) use ($healthCenterId) {
            $query->where('health_center_id', $healthCenterId);
        })->count();

        $totalHealthyHomeReports = HousingSurvey::whereHas('patient', function ($query) use ($healthCenterId) {
            $query->where('health_center_id', $healthCenterId);
        })->count();

        return [
            Stat::make('Total Pasien', $totalPatients)
                ->description('Total pasien yang terdaftar di puskesmas Anda')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Total Laporan PDAM', $totalPdamReports)
                ->description('Total laporan PDAM untuk puskesmas Anda')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Total Konseling Sanitasi', $totalSanitationCounselingReports)
                ->description('Total laporan Konseling Sanitasi untuk puskesmas Anda')
                ->descriptionIcon('heroicon-o-clipboard')
                ->color('warning'),

            Stat::make('Total Rumah Sehat', $totalHealthyHomeReports)
                ->description('Total laporan Rumah Sehat untuk puskesmas Anda')
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
