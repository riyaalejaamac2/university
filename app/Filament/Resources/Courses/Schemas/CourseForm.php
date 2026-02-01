<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('course_name')
                    ->required(),
                TextInput::make('teacher_name')
                    ->required(),
                TextInput::make('semester')
                    ->numeric(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('semester_id')
                    ->numeric(),
            ]);
    }
}
