<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('student_id')
                    ->required(),
                TextInput::make('fullname')
                    ->required(),
                TextInput::make('gender')
                    ->required(),
                TextInput::make('semester')
                    ->numeric(),
                TextInput::make('department')
                    ->required(),
                TextInput::make('semester_id')
                    ->numeric(),
            ]);
    }
}
