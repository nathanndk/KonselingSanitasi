<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    // Menggunakan getTitle() untuk mendapatkan title statis
    protected static ?string $title = 'Dashboard';

    public static function canAccessPage(): bool
    {
        return auth()->user()->role === 'Admin';
    }

    public function getTitle(): string
    {
        return 'Dashboard';
    }

    // Menambahkan greeting ke dalam widget stats
    public function getGreeting(): string
    {
        return 'Selamat datang, ' . auth()->user()->name;
    }

    protected static ?int $sort = 4;


    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Data')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Tanggal Mulai')
                            ->placeholder('Pilih tanggal mulai'),

                        DatePicker::make('endDate')
                            ->label('Tanggal Selesai')
                            ->placeholder('Pilih tanggal akhir')
                            ->rules([
                                'after_or_equal:startDate',
                            ])
                    ]),
            ]);
    }
}
