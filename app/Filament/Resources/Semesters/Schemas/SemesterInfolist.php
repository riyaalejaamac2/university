<?php

namespace App\Filament\Resources\Semesters\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SemesterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('group'),
                TextEntry::make('academic_year'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
