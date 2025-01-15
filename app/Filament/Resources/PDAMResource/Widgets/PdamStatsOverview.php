<?php

namespace App\Filament\Resources\PDAMResource\Widgets;

use App\Models\Pdam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PdamStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Inisialisasi variabel
        $totalReports = 0;
        $lowRisk = 0;
        $mediumRisk = 0;
        $highRisk = 0;

        switch ($user->role) {
            case 'admin':
            case 'dinas_kesehatan':
                // Role "admin" & "dinas_kesehatan" melihat semua laporan
                $totalReports = Pdam::count();
                $lowRisk = Pdam::where('risk_level', 'Rendah')->count();
                $mediumRisk = Pdam::where('risk_level', 'Sedang')->count();
                $highRisk = Pdam::where('risk_level', 'Tinggi')->count();
                break;

            case 'puskesmas':
                // Role "puskesmas" hanya melihat laporan yang event-nya atau datanya
                // berkaitan dengan puskesmas user terkait.
                // Misal: Menyesuaikan relasi "user.healthCenter" dengan ID puskesmas user
                // (Silakan disesuaikan dengan struktur database Anda)
                $totalReports = Pdam::whereHas('user.healthCenter', function ($query) use ($user) {
                    $query->where('id', $user->health_center_id);
                })->count();

                $lowRisk = Pdam::where('risk_level', 'Rendah')
                    ->whereHas('user.healthCenter', function ($query) use ($user) {
                        $query->where('id', $user->health_center_id);
                    })->count();

                $mediumRisk = Pdam::where('risk_level', 'Sedang')
                    ->whereHas('user.healthCenter', function ($query) use ($user) {
                        $query->where('id', $user->health_center_id);
                    })->count();

                $highRisk = Pdam::where('risk_level', 'Tinggi')
                    ->whereHas('user.healthCenter', function ($query) use ($user) {
                        $query->where('id', $user->health_center_id);
                    })->count();
                break;

            case 'petugas':
            case 'kader':
                // Role "petugas" & "kader" hanya melihat laporan yang mereka buat
                // Asumsikan di tabel PDAM ada kolom `created_by` atau `user_id`
                $totalReports = Pdam::where('created_by', $user->id)->count();

                $lowRisk = Pdam::where('created_by', $user->id)
                    ->where('risk_level', 'Rendah')->count();

                $mediumRisk = Pdam::where('created_by', $user->id)
                    ->where('risk_level', 'Sedang')->count();

                $highRisk = Pdam::where('created_by', $user->id)
                    ->where('risk_level', 'Tinggi')->count();
                break;

            default:
                // Role lain tidak bisa melihat apa-apa
                $totalReports = 0;
                $lowRisk = 0;
                $mediumRisk = 0;
                $highRisk = 0;
        }

        return [
            Stat::make('Total Laporan PDAM', $totalReports)
                ->description('Jumlah total laporan PDAM')
                ->descriptionIcon('heroicon-o-document-text')
                ->chart([$totalReports]),

            Stat::make('Tingkat Risiko (Rendah/Sedang/Tinggi)', "{$lowRisk} / {$mediumRisk} / {$highRisk}")
                ->description("Rendah: {$lowRisk} | Sedang: {$mediumRisk} | Tinggi: {$highRisk}")
                ->descriptionIcon('heroicon-o-exclamation-circle'),
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
