<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use App\Models\Status;
use App\Models\Account;
use App\Models\Category;
use Filament\Support\RawJs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
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
                    ->columnSpanFull()
                    ->visible(in_array(Auth::user()?->roles?->first()?->name, ['employee'])),

                    Section::make('Detail Reinbursement')
                        ->description('Add reinbursement details here')
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([
                            Repeater::make('details')
                                ->label('Reinbursement')
                                ->relationship('detailReinbursement')
                                ->columns(2)
                                ->schema([
                                    Select::make('id_category')
                                        ->label('Category')
                                        ->options(fn () => \App\Models\Category::all()->pluck('name', 'id'))
                                        ->required()
                                        ->reactive()
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name === 'employee'
                                            )),

                                    TextInput::make('name')
                                        ->label('Reinbursement Name')
                                        ->required()
                                        ->maxLength(255)
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name === 'employee'
                                            )),

                                    TextInput::make('amount')
                                        ->label('Amount')
                                        ->required()
                                        ->prefix('Rp. ')
                                        ->default(0)
                                        ->reactive()
                                        ->rule(fn ($get) => [
                                            'required',
                                            'lte:' . (\App\Models\Category::find($get('id_category'))?->limit ?? 0),
                                        ])
                                        ->helperText(fn ($get) => $get('id_category')
                                            ? 'Max: Rp. ' . number_format(\App\Models\Category::find($get('id_category'))->limit, 0, ',', '.')
                                            : ''
                                        )
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            // Ambil semua detail data
                                            $allDetails = $get('../../details') ?? [];

                                            // Hitung total hanya jika 'active' == true
                                            $total = collect($allDetails)
                                                ->filter(fn($d) => ($d['active'] ?? false) == true)
                                                ->sum(fn($d) => (int) ($d['amount'] ?? 0));

                                            $set('../../total_amount', $total);
                                        })
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name === 'employee'
                                            )
                                        ),

                                    FileUpload::make('image')
                                        ->label('Image URL')
                                        ->disk('public')
                                        ->directory('reinbursement')
                                        ->image()
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name === 'employee'
                                            )),

                                    Textarea::make('note')
                                        ->maxLength(65535)
                                        ->columnSpanFull()
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name === 'employee'
                                            )),
                                    Toggle::make('active')
                                        ->label('Is Approve')
                                        ->required()
                                        ->default(true)
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            $allDetails = $get('../../details') ?? [];

                                            $total = collect($allDetails)
                                                ->filter(fn($d) => ($d['active'] ?? false) == true)
                                                ->sum(fn($d) => (int) ($d['amount'] ?? 0));

                                            $set('../../total_amount', $total);
                                        })
                                        ->disabled(fn ($record) => 
                                            !(
                                                Auth::user()?->roles?->first()?->name != 'employee'
                                            )),
                                ])
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
                            ])->columns(2)
                            ->maxItems(1)
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['created_by'] = Auth::id();
                                return $data;
                            }),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($record) => 
                        in_array(Auth::user()?->roles?->first()?->name ?? '', ['finance']) 
                            && $record->status_id === 8
                        ),
                        
                Hidden::make('id_employe')
                    ->label('Employee')
                    ->required()
                    ->default(function () {
                        return Auth::user()->id_employe;
                    }),

                TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix("Rp")
                    ->columnSpanFull(),

                Textarea::make('note')
                    ->columnSpanFull(),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->options(
                            Status::whereHas('statusType', function ($query) {
                                $query->where('id', 3);
                            })->pluck('name', 'id')
                        )  
                    ->columnSpanFull()
                    ->visible(in_array(Auth::user()?->roles?->first()?->name, ['division-master'])),
                Hidden::make('approve_by'),
                Hidden::make('approve_at'),
            ]);
    }
}
