<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use App\Models\ReinbursementTRX;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReinbursementTRXInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_account')
                    ->numeric(),
                TextEntry::make('id_employe')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('approve_by')
                    ->placeholder('-'),
                TextEntry::make('approve_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status_id')
                    ->numeric(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('deleted_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ReinbursementTRX $record): bool => $record->trashed()),
            ]);
    }
}
