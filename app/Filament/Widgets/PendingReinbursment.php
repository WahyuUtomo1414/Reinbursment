<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use App\Models\ReinbursementTRX;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;

class PendingReinbursment extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ReinbursementTRX::query())
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
