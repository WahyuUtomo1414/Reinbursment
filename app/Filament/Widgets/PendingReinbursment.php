<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use App\Models\ReinbursementTRX;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class PendingReinbursment extends TableWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ReinbursementTRX::query())
            ->columns([
                TextColumn::make('account.account_number')  
                    ->sortable(),
                TextColumn::make('employe.name')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
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
                    ->badge('info')
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by")
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
