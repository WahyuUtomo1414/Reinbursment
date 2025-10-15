<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use App\Models\Status;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Exports\ReinbursementTRXExporter;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;

class ListReinbursementTRXES extends ListRecords
{
    use ExposesTableToWidgets;
    
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Created Reinbursement'),
            ExportAction::make()
                ->label('Export Data')
                ->exporter(ReinbursementTRXExporter::class)
                ->columnMapping(false)
                ->color('info')
                ->visible(fn (): bool => 
                    in_array(
                        strtolower(Auth::user()?->roles?->first()?->name ?? ''), 
                        ['super_admin']
                    )
                ),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            null => Tab::make('All'),
        ];

        $statuses = Status::where('status_type_id', 3)->pluck('name', 'id');

        foreach ($statuses as $id => $name) {
            $tabs[$name] = Tab::make($name)
                ->query(fn ($query) => $query->where('status_id', $id));
        }

        return $tabs;
    }

    protected function getHeaderWidgets(): array
    {
        return ReinbursementTRXResource::getWidgets();
    }
}
