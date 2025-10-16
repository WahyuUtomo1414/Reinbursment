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
                    ->required()
                    ->validationMessages([
                        'required' => 'The name field is required.',
                    ]),

                TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'The NIK field is required.',
                        'unique' => 'This NIK is already registered.',
                    ]),

                TextInput::make('personal_number')
                    ->label('Personal Number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'The personal number field is required.',
                        'unique' => 'This personal number already exists.',
                    ]),

                Select::make('id_position')
                    ->label('Position')
                    ->required()
                    ->options(\App\Models\Position::all()->pluck('name', 'id')->toArray())
                    ->validationMessages([
                        'required' => 'Please select a position.',
                    ]),

                Select::make('id_division')
                    ->label('Division')
                    ->required()
                    ->options(\App\Models\Division::all()->pluck('name', 'id')->toArray())
                    ->validationMessages([
                        'required' => 'Please select a division.',
                    ]),

                Toggle::make('active')
                    ->label('Active')
                    ->required(),

                Section::make('User Account')
                    ->relationship('user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Username')
                            ->required()
                            ->validationMessages([
                                'required' => 'The username field is required.',
                            ]),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->validationMessages([
                                'required' => 'The email field is required.',
                                'email' => 'Please enter a valid email address.',
                            ]),

                        Select::make('roles')
                            ->label('Roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->default(2)
                            ->preload()
                            ->required()
                            ->visible(in_array(Auth::user()->roles->first()->id ?? null, [6])),

                        TextInput::make('password')
                            ->password()
                            ->label('Reset Password')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->required(fn (string $context): bool => $context === 'create')
                            ->visible(fn (string $context): bool => $context === 'edit')
                            ->validationMessages([
                                'required' => 'The password field is required when creating a new user.',
                            ]),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
