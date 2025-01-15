<?php

namespace App\Filament\Resources\HealthEventResource\Widgets;

use App\Models\HealthEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class HealthEventStatsOverview extends BaseWidget
{
    /**
     * Set widget to span full width.
     */
    protected static bool $canSpanColumns = true;

    /**
     * Batasi widget agar hanya bisa dilihat oleh role tertentu
     */
    public static function canView(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // Role yang diperbolehkan
        return in_array($user->role, ['admin', 'dinas_kesehatan', 'puskesmas', 'petugas', 'kader']);
    }

    /**
     * Menerapkan filter berdasar role user
     */
    private function applyRoleFilter($query)
    {
        $user = Auth::user();

        // Jika user tidak terotentikasi atau role tidak dikenali, kembalikan query yang tidak menghasilkan data
        if (!$user) {
            return $query->where('id', -1);
        }

        switch ($user->role) {
            case 'admin':
            case 'dinas_kesehatan':
                // Melihat semua event => tidak ada filter tambahan
                break;

            case 'puskesmas':
                // Hanya event yang terkait puskesmas-nya
                // Asumsikan ada relasi user->healthCenter
                $query->whereHas('user.healthCenter', function ($q) use ($user) {
                    $q->where('id', $user->health_center_id);
                });
                break;

            case 'petugas':
            case 'kader':
                // Hanya event yang dibuat oleh user tersebut
                // Asumsikan ada kolom created_by di tabel HealthEvent
                $query->where('created_by', $user->id);
                break;

            default:
                // Role lain tidak boleh melihat apa pun
                $query->where('id', -1);
                break;
        }

        return $query;
    }

    protected function getStats(): array
    {
        // Query event yang akan difilter sesuai role user
        $filteredEventQuery = $this->applyRoleFilter(
            HealthEvent::query()->where('event_date', '>=', Carbon::today())
        );

        // Mendapatkan event terdekat
        $nextEvent = (clone $filteredEventQuery)
            ->orderBy('event_date', 'asc')
            ->first();

        // Jumlah event mendatang
        $eventsCount = (clone $filteredEventQuery)->count();

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
