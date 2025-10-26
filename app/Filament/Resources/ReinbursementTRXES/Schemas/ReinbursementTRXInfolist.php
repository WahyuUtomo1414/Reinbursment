<?php

namespace App\Filament\Resources\ReinbursementTRXES\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Actions\Action;

class ReinbursementTRXInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('account.account_name')
                    ->label('Account Name'),
                TextEntry::make('account.account_number')
                    ->label('Account Number'),
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
                                    ->disk('public')
                                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : null)
                                    ->url(fn ($record) => $record->image ? asset('storage/' . $record->image) : null, shouldOpenInNewTab: true)
                                    ->disabled(),
                                
                                TextEntry::make('note')
                                    ->label('Note')
                                    ->getStateUsing(fn ($record) => $record->note ?? '-')
                                    ->disabled(),
                                
                                IconEntry::make('active')
                                    ->label('Is Approve')
                                    ->boolean(),
                            ])
                            ->columns(5)
                            ->disabled(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                    
                Section::make('Detail Payment')
                    ->icon(Heroicon::CurrencyDollar)
                    ->schema([
                        RepeatableEntry::make('paymentReinbursement')
                            ->label('Payment')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Image')
                                    ->disk('public')
                                    ->getStateUsing(fn ($record) =>
                                        $record->image ? asset('storage/' . $record->image) : null
                                    )
                                    ->url(fn ($record) =>
                                        $record->image
                                            ? route('image.download', ['path' => str_replace('storage/', '', $record->image)])
                                            : null
                                    )
                                    ->disabled(false),

                                TextEntry::make('note')
                                    ->label('Note')
                                    ->getStateUsing(fn ($record) => $record->note ?? '-')
                                    ->disabled(),

                                TextEntry::make('status_id')
                                    ->label('Status')
                                    ->getStateUsing(fn ($record) => optional($record->status)->name ?? '-')
                                    ->disabled()
                                    ->badge(),

                                TextEntry::make('createdBy.name')
                                    ->label('Payment By')
                                    ->placeholder('-'),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
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

                Section::make('Status Reimbursement')
                    ->icon(Heroicon::CheckBadge)
                    ->schema([
                        TextEntry::make('status.name')
                            ->label('Status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'Pending' => 'warning',
                                'Approve' => 'success',
                                'Reject'  => 'danger',
                            })
                            ->icon(fn ($state) => match ($state) {
                                'Pending' => 'heroicon-o-clock',
                                'Approve' => 'heroicon-o-check-circle',
                                'Reject'  => 'heroicon-o-x-circle', 
                            }),
                        TextEntry::make('approve.name')
                            ->label('Approved By')
                            ->placeholder('-'),
                        TextEntry::make('approve_at')
                            ->date()
                            ->placeholder('-'),
                    ])->columns(3)->columnSpanFull(),

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

                Section::make('Data Tracked Division')
                    ->icon(Heroicon::UserGroup)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('approve.name')
                                    ->label('Approved By')
                                    ->placeholder('-'),
                                TextEntry::make('approve_at')
                                    ->label('Approved At')
                                    ->placeholder('-'),
                                TextEntry::make('status.name')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'Pending' => 'warning',
                                        'Approve' => 'success',
                                        'Reject'  => 'danger',
                                    })
                                    ->icon(fn ($state) => match ($state) {
                                        'Pending' => 'heroicon-o-clock',
                                        'Approve' => 'heroicon-o-check-circle',
                                        'Reject'  => 'heroicon-o-x-circle', 
                                    }),
                            ]),
                ])->columnSpanFull()->collapsible(),

                Section::make('Data Tracked Payment')
                    ->icon(Heroicon::CreditCard)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('paymentReinbursement.createdBy.name')
                                    ->label('Created By')
                                    ->placeholder('-'),
                                TextEntry::make('paymentReinbursement.created_at')
                                    ->label('Payment At')
                                    ->placeholder('-'),
                                TextEntry::make('paymentReinbursement.status.name')
                                    ->label('Status Payment')
                                    ->badge()
                                    ->placeholder('-')
                                    ->color(fn ($state) => match ($state) {
                                        'Process' => 'warning',
                                        'Paid' => 'success',
                                        'Rejected'  => 'danger',
                                    })
                                    ->icon(fn ($state) => match ($state) {
                                        'Process' => 'heroicon-o-clock',
                                        'Paid' => 'heroicon-o-check-circle',
                                        'Rejected'  => 'heroicon-o-x-circle',
                                    }),
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
