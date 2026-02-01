<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'fullname')
                    ->searchable()
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->required(),
                TextInput::make('semester')
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('academic_year'),
                TextInput::make('semester_id')
                    ->numeric(),
            ]);
    }
}
