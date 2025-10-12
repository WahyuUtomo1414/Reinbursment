<?php

namespace App\Filament\Widgets;

use App\Models\Status;
use Filament\Tables\Table;
use App\Models\ReinbursementTRX;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class PendingReinbursment extends TableWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;
    
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
                SelectFilter::make('status_id')
                    ->label('Status')
                    ->options(fn () => Status::where('status_type_id', 3)->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih status...'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => url("/admin/reinbursement-t-r-x-e-s/{$record->id}"))
                    ->openUrlInNewTab(false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
