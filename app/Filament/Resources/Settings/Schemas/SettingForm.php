<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('university_name')
                    ->required()
                    ->default('University Name'),
                TextInput::make('academic_year')
                    ->required()
                    ->default('2025-2026'),
                TextInput::make('current_semester')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('attendance_status')
                    ->required()
                    ->default('Open'),
            ]);
    }
}
