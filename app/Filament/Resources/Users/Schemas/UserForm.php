<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Employe;
use App\Models\Position;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('id_employe')
                    ->label('Employee')
                    ->options(Employe::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->disabled(fn ($record) => 
                        !(
                            Auth::user()?->roles?->first()?->name != 'employee'
                        )),
                Select::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required()
                    ->visible(in_array(Auth::user()->roles->first()->id ?? null, [6])),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
