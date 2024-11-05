<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function canAccessPage(): bool
    {
        return auth()->user()->role === 'Admin';
    }
}
