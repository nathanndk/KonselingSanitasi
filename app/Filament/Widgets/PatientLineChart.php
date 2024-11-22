<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class PatientLineChart extends ChartWidget
{
    protected static ?string $heading;

    protected static bool $isLazy = true;

    protected static ?int $sort = 3;


    // Inisialisasi heading secara dinamis
    public static function boot()
    {
        static::$heading = 'Total Pasien ' . Carbon::now()->year . '';
    }

    protected function getData(): array
    {
        // Initialize an array with 12 months
        $monthlyPatientCounts = array_fill(0, 12, 0);
        $currentYear = Carbon::now()->year;

        // Query to get patient counts grouped by month
        $patients = Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get();

        // Map the counts to their respective months as integers
        foreach ($patients as $patient) {
            $monthlyPatientCounts[$patient->month - 1] = (int)$patient->count;
        }

        return [
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ], // Chart labels
            'datasets' => [
                [
                    'label' => 'Pasien Baru', // Dataset label
                    'data' => $monthlyPatientCounts, // Data points for each month
                    'borderColor' => '#fbc02d', // Line color
                    'backgroundColor' => 'rgba(255, 235, 59, 0.5)', // Fill color under the line
                    'tension' => 0.4, // Smooth the line
                ]
            ],
            'options' => [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true,
                                'stepSize' => 1, // Ensure integer steps
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Specifies that the chart type is line
    }
}
