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
        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Periksa role dan filter data berdasarkan aturan
        $query = Patient::query();

        // Hitung statistik
        $totalPatients = $query->count();
        $malePatients = $query->where('gender', 'L')->count();
        $femalePatients = $query->where('gender', 'P')->count();

        return [
            Stat::make('Total Pasien', $totalPatients)
                ->description("👨 Laki-laki: {$malePatients} | 👩 Perempuan: {$femalePatients}")
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([$totalPatients, $malePatients, $femalePatients]),

            Stat::make('Total Laki-laki', $malePatients)
                ->description('Total pasien laki-laki yang terdata')
                ->descriptionIcon('heroicon-o-user')
                ->color('primary')
                ->chart([$malePatients]),

            Stat::make('Total Perempuan', $femalePatients)
                ->description('Total pasien perempuan yang terdata')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('warning')
                ->chart([$femalePatients]),
        ];
    }

    public static function canView(): bool
    {
        // Cek apakah user login dan role sesuai
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }
}
