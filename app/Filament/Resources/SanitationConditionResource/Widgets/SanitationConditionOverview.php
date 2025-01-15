<?php

namespace App\Filament\Resources\SanitationConditionResource\Widgets;

use App\Models\SanitationCondition;
use App\Models\HealthEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SanitationConditionOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Variabel untuk menyimpan total laporan
        $totalReports = 0;

        // Logika akses berdasarkan role
        switch ($user->role) {
            case 'admin':
            case 'dinas_kesehatan':
                // Admin dan Dinas Kesehatan melihat semua laporan
                $totalReports = SanitationCondition::count();
                break;

            case 'puskesmas':
                // Mengambil semua laporan yang event-nya memiliki health_center_id = $user->health_center_id
                $totalReports = SanitationCondition::whereHas('user.healthCenter', function ($query) use ($user) {
                    $query->where('id', $user->health_center_id);
                })->count();
                break;

            case 'petugas':
            case 'kader':
                // Petugas dan Kader melihat laporan yang mereka buat
                $totalReports = SanitationCondition::where('created_by', $user->id)->count();
                break;

            default:
                // Role lain tidak memiliki akses
                $totalReports = 0;
        }

        return [
            Stat::make('Total Laporan Konseling Sanitasi', $totalReports)
                ->description('Jumlah total laporan Konseling Sanitasi berdasarkan role Anda')
                ->descriptionIcon('heroicon-o-document-text'),
        ];
    }

    public static function canView(): bool
    {
        // Cek apakah user login dan role sesuai
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // Role yang diizinkan
        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }
}
