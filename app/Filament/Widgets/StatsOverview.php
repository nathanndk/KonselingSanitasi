<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use App\Models\Pdam;
use App\Models\SanitationCondition;
use App\Models\HousingSurvey;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    protected static ?int $sort = 1;

    protected function getFilters(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Tanggal Mulai')
                ->placeholder('Pilih tanggal mulai'),

            DatePicker::make('endDate')
                ->label('Tanggal Selesai')
                ->placeholder('Pilih tanggal akhir'),
        ];
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $startDate = isset($this->filters['startDate']) ? Carbon::parse($this->filters['startDate']) : null;
        $endDate = isset($this->filters['endDate']) ? Carbon::parse($this->filters['endDate']) : null;

        // Query untuk pasien
        $patientsQuery = Patient::query();

        // Query untuk PDAM, Konseling Sanitasi, dan Rumah Sehat
        $pdamQuery = Pdam::query();
        $sanitationQuery = SanitationCondition::query();
        $housingQuery = HousingSurvey::query();

        if (in_array($user->role, ['kader', 'petugas'])) {
            // Filter untuk Kader dan Petugas: Hanya data yang mereka buat
            $patientsQuery->where('created_by', $user->id);
            $pdamQuery->where('created_by', $user->id);
            $sanitationQuery->where('created_by', $user->id);
            $housingQuery->where('created_by', $user->id);
        } elseif (in_array($user->role, ['puskesmas'])) {
            // Filter untuk Puskesmas: Data sesuai health_center_id
            $patientsQuery->where(function ($query) use ($user) {
                $query->whereHas('user.healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                })
                ->orWhereHas('healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                });
            });

            $pdamQuery->where(function ($query) use ($user) {
                $query->whereHas('user.healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                })
                ->orWhereHas('healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                });
            });

            $sanitationQuery->where(function ($query) use ($user) {
                $query->whereHas('user.healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                })
                ->orWhereHas('healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                });
            });

            $housingQuery->where(function ($query) use ($user) {
                $query->whereHas('user.healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                })
                ->orWhereHas('healthCenter', function ($subQuery) use ($user) {
                    $subQuery->where('id', $user->health_center_id);
                });
            });
        }
        // Admin dan Dinkes tidak memerlukan filter tambahan

        // Terapkan filter tanggal
        $patientsQuery->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $pdamQuery->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $sanitationQuery->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        $housingQuery->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate));

        // Hitung total data
        $totalNewPatients = $patientsQuery->count();
        $totalNewPdamReports = $pdamQuery->count();
        $totalNewSanitationCounselings = $sanitationQuery->count();
        $totalNewHealthyHomes = $housingQuery->count();

        return [
            Stat::make('Pasien Baru', $totalNewPatients)
                ->description('Jumlah pasien baru yang tercatat')
                ->descriptionIcon('heroicon-o-user')
                ->color('warning'),

            Stat::make('Laporan PDAM Baru', $totalNewPdamReports)
                ->description('Jumlah laporan PDAM baru')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Konseling Sanitasi Baru', $totalNewSanitationCounselings)
                ->description('Jumlah konseling sanitasi baru')
                ->descriptionIcon('heroicon-o-clipboard')
                ->color('success'),

            Stat::make('Rumah Sehat Baru', $totalNewHealthyHomes)
                ->description('Jumlah laporan rumah sehat baru')
                ->descriptionIcon('heroicon-o-home')
                ->color('danger'),
        ];
    }

    public static function canView(): bool
    {
        // Pastikan hanya Admin yang dapat melihat widget ini
        return Auth::check() && Auth::user()->hasRole('Admin');
    }
}
