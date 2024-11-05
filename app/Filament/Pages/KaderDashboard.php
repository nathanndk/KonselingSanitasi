<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class KaderDashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $routePath = 'Kader';

    protected static ?string $title = 'Kader dashboard';

    protected static string $view = 'filament.pages.kader-dashboard';

    public static function canAccessPage(): bool
    {
        return auth()->user()->role === 'Kader';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'Kader';
    }

}
