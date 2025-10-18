<?php

namespace App\Filament\Widgets;

use App\Models\Status;
use App\Models\Employe;
use Filament\Tables\Table;
use App\Models\ReinbursementTRX;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;
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
            ->query(function (): Builder {
                $user = Auth::user();

                if (!$user) {
                    return ReinbursementTRX::query()->whereRaw('1=0');
                }

                $roles = $user->roles->pluck('name')->toArray();

                if (in_array('super_admin', $roles) || in_array('finance', $roles)) {
                    return ReinbursementTRX::query();
                }

                if (in_array('division-master', $roles)) {
                    $employe = Employe::find($user->id_employe);
                    $divisionId = $employe?->id_division;

                    if (!$divisionId) {
                        return ReinbursementTRX::query()->whereRaw('1=0');
                    }

                    return ReinbursementTRX::query()
                        ->whereHas('employe', fn ($q) => $q->where('id_division', $divisionId));
                }
                return ReinbursementTRX::query()
                    ->where('created_by', $user->id);
            })

            ->columns([
                TextColumn::make('account.account_number')  
                    ->sortable()
                    ->searchable(),
                TextColumn::make('employe.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->prefix('Rp. ')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('approve.name')
                    ->searchable()
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('approve_at')
                    ->date()
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status.name')
                    ->badge('info')
                    ->sortable()
                    ->color(fn ($state) => match ($state) {
                        'Pending' => 'warning',
                        'Approve' => 'success',
                        'Reject'  => 'danger',
                    })
                    ->icon(fn ($state) => match ($state) {
                        'Pending' => 'heroicon-o-clock',
                        'Approve' => 'heroicon-o-check-circle',
                        'Reject'  => 'heroicon-o-x-circle',
                    })
                    ->searchable(),
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
