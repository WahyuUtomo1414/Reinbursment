<?php

namespace App\Filament\Resources\Statuses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class StatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status_type_id')
                    ->relationship('statusType', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->columnSpanFull()
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Toggle::make('active')
                            ->required(),
                    ])
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
