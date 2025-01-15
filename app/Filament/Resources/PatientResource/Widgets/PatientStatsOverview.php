<?php

namespace App\Filament\Resources\PatientResource\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PatientStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = Patient::selectRaw("gender, COUNT(*) as total")
            ->groupBy('gender')
            ->get()
            ->pluck('total', 'gender');

        $totalPatients = $stats->sum();
        $malePatients = $stats->get('L', 0);
        $femalePatients = $stats->get('P', 0);

        return [
            Stat::make('Total Pasien', $totalPatients)
                ->description('Total pasien yang terdata')
                ->descriptionIcon('heroicon-o-user-group'),

            Stat::make('Total Laki-laki', $malePatients)
                ->description('Total pasien laki-laki yang terdata')
                ->descriptionIcon('heroicon-o-users'),

            Stat::make('Total Perempuan', $femalePatients)
                ->description('Total pasien perempuan yang terdata')
                ->descriptionIcon('heroicon-o-users'),
        ];
    }

    public static function canView(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }
}
