<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReinbursementTRXForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_account')
                    ->required()
                    ->numeric(),
                TextInput::make('id_employe')
                    ->required()
                    ->numeric(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('note')
                    ->columnSpanFull(),
                TextInput::make('approve_by'),
                DatePicker::make('approve_at'),
                TextInput::make('status_id')
                    ->required()
                    ->numeric(),
                TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
                TextInput::make('deleted_by')
                    ->numeric(),
            ]);
    }
}
