<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use Filament\Schemas\Schema;
use App\Models\ReinbursementTRX;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ReinbursementTRXInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('account.account_name')
                    ->label('Account Name'),
                TextEntry::make('employe.name')
                    ->label('Employe Name'),

                Section::make('Detail Reimbursement')
                    ->description('List of reimbursement details')
                    ->icon(Heroicon::CurrencyDollar)
                    ->schema([
                        RepeatableEntry::make('detailReinbursement')
                            ->schema([
                                TextEntry::make('category.name')
                                    ->label('Category')
                                    ->getStateUsing(fn ($record) => optional($record->category)->name ?? '-')
                                    ->disabled(),

                                TextEntry::make('name')
                                    ->label('Reimbursement Name')
                                    ->getStateUsing(fn ($record) => $record->name ?? '-')
                                    ->disabled(),

                                TextEntry::make('amount')
                                    ->label('Amount')
                                    ->getStateUsing(fn ($record) => 'Rp. ' . number_format($record->amount, 0, ',', '.'))
                                    ->disabled(),

                                ImageEntry::make('image')
                                    ->label('Image')
                                    ->disk('public')
                                    ->imagesize(140)
                                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : '-')
                                    ->disabled(),
                                
                                TextEntry::make('note')
                                    ->label('Note')
                                    ->getStateUsing(fn ($record) => $record->note ?? '-')
                                    ->disabled(),
                            ])
                            ->columns(5)
                            ->disabled(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                    
                Section::make('Detail Payment')
                    ->description('Reimbursement payments')
                    ->icon(Heroicon::CurrencyDollar)
                    ->schema([
                        Repeater::make('paymentReinbursement')
                            ->relationship('paymentReinbursement')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Image')
                                    ->disk('public')
                                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : '-')
                                    ->disabled(),

                                TextEntry::make('note')
                                    ->label('Note')
                                    ->disabled()
                                    ->getStateUsing(fn ($record) => $record->note ?? '-'),

                                TextEntry::make('status.name')
                                    ->label('Status')
                                    ->disabled()
                                    ->getStateUsing(fn ($record) => optional($record->status)->name ?? '-'),
                            ])
                            ->columns(2)
                            ->disabled(),
                    ])
                    ->columnSpanFull(),

                TextEntry::make('total_amount')
                    ->numeric()
                    ->prefix('Rp ')
                    ->label('Total Amount')
                    ->formatStateUsing(fn (string $state): string => number_format($state)),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('approve_by')
                    ->label('Approved By')
                    ->placeholder('-')
                    ->getStateUsing(function ($record) {
                        return optional($record->approve)->name ?? '-';
                    }),
                TextEntry::make('approve_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status.name')
                    ->label('Status')
                    ->badge(),
                Section::make('Data Tracked')
                    ->icon(Heroicon::ArchiveBox)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('createdBy.name')
                                    ->label('Created By')
                                    ->placeholder('-'),
                                TextEntry::make('updatedBy.name')
                                    ->label('Updated By')
                                    ->placeholder('-'),
                                TextEntry::make('deletedBy.name')
                                    ->label('Deleted By')
                                    ->placeholder('-'),
                            ]),
                ])->columnSpanFull()->collapsible(),
                Section::make('Timestamps')
                    ->icon(Heroicon::Clock)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d/F/Y H:i'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d/F/Y H:i'),
                            ]),
                ])->columnSpanFull()->collapsible(),
            ]);
    }
}
