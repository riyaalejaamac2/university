<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('student_id'),
                TextEntry::make('fullname'),
                TextEntry::make('gender'),
                TextEntry::make('semester')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('department'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('semester_id')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
