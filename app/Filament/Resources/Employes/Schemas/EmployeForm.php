<?php

namespace App\Filament\Resources\Employes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class EmployeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('nik')
                    ->required(),
                TextInput::make('personal_number')
                    ->required(),
                Select::make('id_position')
                    ->required()
                    ->options(\App\Models\Position::all()->pluck('name', 'id')->toArray())
                    ->label('Position'),
                Toggle::make('active')
                    ->required(),
                Section::make('User Account')
                    ->relationship('user') // relasi hasOne ke User
                    ->schema([
                        TextInput::make('name')
                            ->label('Username')
                            ->required(),

                        TextInput::make('email')
                            ->email()
                            ->required(),

                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
        ]);
    }
}
