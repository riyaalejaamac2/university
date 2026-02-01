<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PortalLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        session()->regenerate();

        // If the user is an admin, always go to admin
        if (Auth::user()->hasRole('super_admin')) {
            return redirect()->intended('/admin');
        }

        // Otherwise go to the system dashboard
        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.portal-login')
            ->layout('filament-panels::components.layout.base');
    }
}
