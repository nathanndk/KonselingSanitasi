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
        // Validasi filter tanggal
        $startDate = isset($this->filters['startDate']) ? Carbon::parse($this->filters['startDate']) : null;
        $endDate = isset($this->filters['endDate']) ? Carbon::parse($this->filters['endDate']) : null;

        // Query data pasien dengan optimisasi
        $patientStats = Patient::selectRaw("COUNT(*) as total,
                                            SUM(gender = 'L') as male,
                                            SUM(gender = 'P') as female")
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->first();

        $totalPatients = $patientStats->total;
        $malePatients = $patientStats->male;
        $femalePatients = $patientStats->female;

        // Query laporan lainnya
        $totalPdamReports = Pdam::when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->count();

        $totalSanitationCounselingReports = SanitationCondition::when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->count();

        $totalHealthyHomeReports = HousingSurvey::when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
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
        return Auth::check() && Auth::user()->hasRole('Admin');
    }
}
