<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    protected static string $layout = 'filament-panels::components.layout.base';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return null;
    }

    protected function getFormComponents(): array
    {
        return [
            $this->getEmailFormComponent()
                ->label('')
                ->placeholder('Username')
                ->prefixIcon('heroicon-m-user'),
            $this->getPasswordFormComponent()
                ->label('')
                ->placeholder('Password')
                ->prefixIcon('heroicon-m-lock-closed'),
        ];
    }

    public function redirectUrl(): string
    {
        if (auth()->user()->hasRole('super_admin')) {
            return '/admin';
        }

        return route('dashboard');
    }
}
