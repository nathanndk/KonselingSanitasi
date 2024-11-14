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

class KaderStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    protected function getFilters(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Start Date')
                ->placeholder('Pilih tanggal mulai'),

            DatePicker::make('endDate')
                ->label('End Date')
                ->placeholder('Pilih tanggal akhir'),
        ];
    }

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $userId = Auth::id(); // ID pengguna yang sedang login

        // Filter queries based on selected start and end date and created_by user
        $totalPatients = Patient::where('created_by', $userId)
                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                ->count();

        $malePatients = Patient::where('gender', 'L')
                                ->where('created_by', $userId)
                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                ->count();

        $femalePatients = Patient::where('gender', 'P')
                                ->where('created_by', $userId)
                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                ->count();

        $totalPdamReports = Pdam::where('created_by', $userId)
                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                ->count();

        $totalSanitationCounselingReports = SanitationCondition::where('created_by', $userId)
                                                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                                                ->count();

        $totalHealthyHomeReports = HousingSurvey::where('created_by', $userId)
                                                ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
                                                ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
                                                ->count();

        return [
            Stat::make('Total Pasien', $totalPatients)
                ->description("👨 Laki-laki: {$malePatients} | 👩 Perempuan: {$femalePatients}")
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([$totalPatients, $malePatients, $femalePatients]),

            Stat::make('Total Laporan PDAM', $totalPdamReports)
                ->description('Total laporan PDAM yang sudah didata')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary')
                ->chart([$totalPdamReports, $totalPdamReports - 2, $totalPdamReports - 1, $totalPdamReports]),

            Stat::make('Total Konseling Sanitasi', $totalSanitationCounselingReports)
                ->description('Total laporan Konseling Sanitasi')
                ->descriptionIcon('heroicon-o-clipboard')
                ->color('warning')
                ->chart([$totalSanitationCounselingReports, $totalSanitationCounselingReports - 1, $totalSanitationCounselingReports - 3, $totalSanitationCounselingReports]),

            Stat::make('Total Rumah Sehat', $totalHealthyHomeReports)
                ->description('Total laporan Rumah Sehat yang sudah didata')
                ->descriptionIcon('heroicon-o-home')
                ->color('info')
                ->chart([$totalHealthyHomeReports, $totalHealthyHomeReports - 2, $totalHealthyHomeReports - 1, $totalHealthyHomeReports]),
        ];
    }

    public static function canView(): bool
    {
        // Pastikan hanya Admin yang dapat melihat widget ini
        return Auth::check() && Auth::user()->hasRole('Kader');
    }
}
