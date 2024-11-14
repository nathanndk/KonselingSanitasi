<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function canAccessPage(): bool
    {
        return auth()->user()->role === 'Admin';
    }

    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema(
            [
                // TextInput::make('name'),
                DatePicker::make('startDate')
                    ->label('Start Date')
                    ->placeholder('Pilih tanggal mulai'),

                DatePicker::make('endDate')
                    ->label('End Date')
                    ->placeholder('Pilih tanggal akhir')
                    ->rules([
                        'after_or_equal:startDate', // Pastikan endDate setelah startDate
                    ]),
                // Toggle::make('active')
            ]
        );
    }
}
