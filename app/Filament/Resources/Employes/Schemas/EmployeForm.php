<?php

namespace App\Filament\Resources\Employes\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
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
                Select::make('id_division')
                    ->required()
                    ->options(\App\Models\Division::all()->pluck('name', 'id')->toArray())
                    ->label('Division'),
                Toggle::make('active')
                    ->required(),
                Section::make('User Account')
                    ->relationship('user') 
                    ->schema([
                        TextInput::make('name')
                            ->label('Username')
                            ->required(),

                        TextInput::make('email')
                            ->email()
                            ->required(),

                        Hidden::make('roles')
                            ->label('Role')
                            ->default(2),

                        TextInput::make('password')
                            ->password()
                            ->label('Reset Password')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->required(fn (string $context): bool => $context === 'create')
                            ->visible(fn (string $context): bool => $context === 'edit'),

                    ])
                    ->columns(3)
                    ->columnSpanFull(),
        ]);
    }
}
