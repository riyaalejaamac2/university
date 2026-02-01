<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class LogoutPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-left-on-rectangle';

    protected static ?string $navigationLabel = 'Logout';

    protected static string|\UnitEnum|null $navigationGroup = 'Account';

    protected static ?int $navigationSort = 1000;

    protected string $view = 'filament.pages.logout-page';

    public function mount(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(filament()->getLoginUrl());
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view($this->view)->layout('filament-panels::components.layout.base');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
