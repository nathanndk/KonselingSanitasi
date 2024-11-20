<?php

namespace App\Filament\Resources\HealthEventResource\Widgets;

use App\Models\HealthEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class HealthEventStatsOverview extends BaseWidget
{
    /**
     * Set widget to span full width.
     */
    protected static bool $canSpanColumns = true;

    protected function getStats(): array
    {
        // Mendapatkan event terdekat berdasarkan tanggal hari ini atau mendatang
        $nextEvent = HealthEvent::where('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->first();

        $eventsCount = HealthEvent::where('event_date', '>=', Carbon::today())->count();

        return [
            Stat::make('Acara Terdekat', $nextEvent?->title ?? 'Tidak Ada Event')
                ->description(
                    $nextEvent
                        ? 'Tanggal: ' . date('d M Y', strtotime($nextEvent->event_date)) .
                          ' | Waktu: ' . date('H:i', strtotime($nextEvent->start_time)) . ' - ' . date('H:i', strtotime($nextEvent->end_time))
                        : 'Belum ada event terjadwal'
                )
                ->icon('heroicon-o-calendar')
                ->color($nextEvent ? 'success' : 'secondary')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition',
                    'wire:click' => "\$dispatch('setEventFilter', { filter: 'upcoming' })",
                ]),

            Stat::make('Total Acara Mendatang', $eventsCount)
                ->description(
                    $eventsCount > 0
                        ? "Ada $eventsCount acara yang dijadwalkan."
                        : 'Belum ada acara yang dijadwalkan.'
                )
                ->icon('heroicon-o-calendar')
                ->color($eventsCount > 0 ? 'primary' : 'secondary')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition',
                    'wire:click' => "\$dispatch('setEventFilter', { filter: 'all' })",
                ]),
        ];
    }
}
