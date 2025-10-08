<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use App\Models\Status;
use App\Models\Account;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class ReinbursementTRXForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_account')
                    ->label('Account')
                    ->options(function () {
                        return Account::where('created_by', Auth::id())
                            ->get()
                            ->mapWithKeys(function ($account) {
                                // key = id, value = "provider - name"
                                return [$account->id => "{$account->provider} - {$account->account_name}"];
                            })
                            ->toArray();
                    })
                    ->required()
                    ->columnSpanFull(),
                Hidden::make('id_employe')
                    ->label('Employee')
                    ->required()
                    ->default(function () {
                        return Auth::user()->id_employe;
                    }),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp. ')
                    ->default(0)
                    ->columnSpanFull(),
                Textarea::make('note')
                    ->columnSpanFull(),
                TextInput::make('approve_by'),
                DatePicker::make('approve_at'),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->options(Status::all()->pluck('name', 'id'))
                    ->columnSpanFull(),
            ]);
    }
}
