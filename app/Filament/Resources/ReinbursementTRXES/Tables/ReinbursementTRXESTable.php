<?php

namespace App\Filament\Resources\ReinbursementTRXES\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;

class ReinbursementTRXESTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('account.account_number')  
                    ->sortable(),
                TextColumn::make('employe.name')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->prefix('Rp. ')
                    ->sortable(),
                TextColumn::make('approve_by')
                    ->searchable()
                    ->placeholder('-')
                    ->getStateUsing(function ($record) {
                        return optional($record->approve)->name ?: '-';
                    }),
                TextColumn::make('approve_at')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label('Status Reinbursment')
                    ->sortable()
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
                
                TextColumn::make('paymentReinbursement.status.name')
                    ->label('Status Payment')
                    ->sortable()
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

                TextColumn::make('paymentReinbursement.createdBy.name')
                    ->label('Paid By')
                    ->placeholder('-'),
                
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'name')
                    ->preload()
                    ->searchable()
                    ->indicator('Status'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn ($record) => 
                        !(
                            Auth::user()?->roles?->first()?->name === 'employee' 
                            && $record->status_id === 8
                        )
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
