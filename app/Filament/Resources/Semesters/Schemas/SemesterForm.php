<?php

namespace App\Filament\Resources\Semesters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SemesterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('group')
                    ->required()
                    ->default('None'),
                TextInput::make('academic_year')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('Active'),
            ]);
    }
}
