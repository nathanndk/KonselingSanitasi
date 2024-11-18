<?php

namespace App\Filament\Resources\PDAMResource\Widgets;

use App\Models\Pdam;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PdamStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total laporan PDAM
        $totalReports = Pdam::count();

        // Tingkat risiko (Rendah, Sedang, Tinggi)
        $lowRisk = Pdam::where('risk_level', 'Rendah')->count();
        $mediumRisk = Pdam::where('risk_level', 'Sedang')->count();
        $highRisk = Pdam::where('risk_level', 'Tinggi')->count();

        return [
            Stat::make('Total Laporan PDAM', $totalReports)
                ->description('Jumlah total laporan PDAM')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success')
                ->chart([$totalReports]),

            Stat::make('Tingkat Risiko (Rendah/Sedang/Tinggi)', "{$lowRisk} / {$mediumRisk} / {$highRisk}")
                ->description("Rendah: {$lowRisk} | Sedang: {$mediumRisk} | Tinggi: {$highRisk}")
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning')
                ->chart([$lowRisk, $mediumRisk, $highRisk]),
        ];
    }
}
