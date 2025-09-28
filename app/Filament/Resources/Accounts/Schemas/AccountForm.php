<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(['bank' => 'Bank', 'e-wallet' => 'E wallet'])
                    ->required(),
                TextInput::make('provider')
                    ->label('Provider (Bank/E wallet name)')
                    ->required(),
                TextInput::make('account_name')
                    ->required(),
                TextInput::make('account_number')
                    ->required()
                    ->maxLength(20),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
