<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AttendanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('student.id')
                    ->label('Student'),
                TextEntry::make('course.id')
                    ->label('Course'),
                TextEntry::make('semester')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('academic_year')
                    ->placeholder('-'),
                TextEntry::make('semester_id')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
