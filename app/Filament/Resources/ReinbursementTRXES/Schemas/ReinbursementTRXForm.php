<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use App\Models\Status;
use App\Models\Account;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

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

                    Section::make('Detail Reinbursement')
                        ->description('Add reinbursement details here')
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([
                            Repeater::make('details')
                                ->label('Reinbursement')
                                ->relationship('detailReinbursement')
                                ->schema([
                                    Select::make('id_category')
                                        ->label('Category')
                                        ->options(function () {
                                            return \App\Models\Category::all()->pluck('name', 'id');
                                        })
                                        ->required(),
                                    TextInput::make('name')
                                        ->label('Reinbursement Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('amount')
                                        ->required()
                                        ->numeric()
                                        ->prefix('Rp. ')
                                        ->default(0),
                                    FileUpload::make('image')
                                        ->label('Image URL')
                                        ->disk('public')
                                        ->directory('reinbursement')
                                        ->image(),
                                    Textarea::make('note')
                                        ->maxLength(65535)
                                        ->columnSpanFull(),
                                ])->columns(2),
                        ])
                        ->columnSpanFull(),
                Section::make('Detail Payment')
                        ->description('Add reinbursement payment here')
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([
                            Repeater::make('payment')
                                ->label('Payment')
                                ->relationship('paymentReinbursement')
                                ->schema([
                                    FileUpload::make('image')
                                        ->label('Image Payment')
                                        ->disk('public')
                                        ->directory('reinbursement_payment')
                                        ->image()
                                        ->columnSpanFull(),
                                    Textarea::make('note')
                                        ->columnSpanFull(),
                                    Select::make('status_id')
                                        ->required()
                                        ->label('Status')
                                        ->default(4)
                                        ->options(
                                                Status::whereHas('statusType', function ($query) {
                                                    $query->where('id', 2);
                                                })->pluck('name', 'id')
                                            )  
                                        ->columnSpanFull(),
                                ])->columns(2)->maxItems(1),
                        ])
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
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->default(7)
                    ->options(
                            Status::whereHas('statusType', function ($query) {
                                $query->where('id', 3);
                            })->pluck('name', 'id')
                        )  
                    ->columnSpanFull(),
                Hidden::make('approve_by'),
                Hidden::make('approve_at'),
            ]);
    }
}
