<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
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
                TextInput::make('password')
                    ->password()
                    ->required(),
                Toggle::make('active')
                    ->required(),

                Section::make('Employee Information')
                ->schema([
                    TextInput::make('employe.name')
                        ->label('Name')
                        ->required(),

                    TextInput::make('employe.nik')
                        ->label('NIK')
                        ->required(),

                    TextInput::make('employe.personal_number')
                        ->label('Personal Number'),

                    Select::make('employe.position_id')
                        ->label('Position')
                        ->relationship('employe.position', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required(),
                            Textarea::make('description'),
                        ]),
                ])->columnSpanFull()->columns(2),
            ]);
    }
}
