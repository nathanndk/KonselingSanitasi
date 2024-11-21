<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\ChartWidget;

class PatientBarChart extends ChartWidget
{
    protected static ?string $heading = 'Patient Count';

    protected function getData(): array
    {
        // Get the count of patients, optionally filtered by date or other criteria
        $totalPatients = Patient::count();
        $malePatients = Patient::where('gender', 'L')->count();
        $femalePatients = Patient::where('gender', 'P')->count();

        return [
            'labels' => ['Total Patients', 'Male Patients', 'Female Patients'], // Chart labels
            'datasets' => [
                [
                    'label' => 'Patients Count', // Dataset label
                    'data' => [$totalPatients, $malePatients, $femalePatients], // Data points
                    'backgroundColor' => ['#4caf50', '#2196f3', '#f44336'], // Bar colors
                    'borderColor' => ['#388e3c', '#1976d2', '#d32f2f'], // Bar border colors
                    'borderWidth' => 1, // Border width
                ]
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Specifies that the chart type is bar
    }
}
