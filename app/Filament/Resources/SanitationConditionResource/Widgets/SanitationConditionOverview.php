<?php

namespace App\Filament\Resources\SanitationConditionResource\Widgets;

use App\Models\SanitationCondition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SanitationConditionOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Query default untuk SanitationCondition
        $query = SanitationCondition::query();

        // Logika akses berdasarkan role
        if ($user->role === 'Puskesmas') {
            // Puskesmas hanya bisa melihat laporan terkait puskesmas mereka
            $query->where('puskesmas_id', $user->health_center_id);
        } elseif ($user->role === 'Petugas' || $user->role === 'Kader') {
            // Petugas dan Kader hanya bisa melihat laporan yang mereka buat
            $query->where('created_by', $user->id);
        }

        // Hitung total laporan
        $totalReports = $query->count();

        return [
            Stat::make('Total Laporan Konseling Sanitasi', $totalReports)
                ->description('Jumlah total laporan konseling sanitasi')
                ->descriptionIcon('heroicon-o-home')
                ->color('info')
                ->chart([$totalReports]),
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
