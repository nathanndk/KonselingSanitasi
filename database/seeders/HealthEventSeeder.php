<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HealthEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'RW 05 Kelurahan Banyumanik',
            'RT 03/RW 07 Kelurahan Tembalang',
            'RW 10 Kelurahan Pedurungan Tengah',
            'RT 01/RW 02 Kelurahan Mijen',
            'RW 12 Kelurahan Gunungpati',
        ];

        $eventTypes = [
            'Pengecekan Kualitas Air PDAM',
            'Konseling Sanitasi',
            'Pemeriksaan Rumah Sehat',
            'Edukasi dan Pengecekan Air',
            'Penyuluhan Sanitasi',
        ];

        $events = [];

        for ($i = 0; $i < 5; $i++) {
            $isToday = (bool) random_int(0, 1); // Acara sekarang atau mendatang
            $eventDate = $isToday ? Carbon::today() : Carbon::now()->addDays(random_int(1, 14));

            $events[] = [
                'title' => $eventTypes[array_rand($eventTypes)] . ' ' . $locations[array_rand($locations)],
                'description' => 'Kegiatan ' . strtolower($eventTypes[array_rand($eventTypes)]) . ' di ' . $locations[array_rand($locations)] . ', Semarang.',
                'event_date' => $eventDate->toDateString(),
                'start_time' => $eventDate->setTime(random_int(8, 10), 0, 0),
                'end_time' => $eventDate->setTime(random_int(12, 14), 0, 0),
                'health_center_id' => random_int(1, 5), // ID health center acak
                'created_by' => 1, // Admin ID atau user ID
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('health_events')->insert($events);
    }
}
