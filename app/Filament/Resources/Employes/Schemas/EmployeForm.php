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
                    ->label('Full Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->validationMessages([
                        'required' => 'The email field is required.',
                        'email' => 'Please enter a valid email address.',
                        'unique' => 'This email is already registered.',
                    ]),

                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('personal_number')
                    ->label('Personal Number')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('id_position')
                    ->label('Position')
                    ->required()
                    ->options(\App\Models\Position::pluck('name', 'id')),

                Select::make('id_division')
                    ->label('Division')
                    ->required()
                    ->options(\App\Models\Division::pluck('name', 'id')),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
