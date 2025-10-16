<?php

namespace App\Filament\Pages;

use App\Models\Status;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Utilities\Get;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter Reimbursement')
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Start Date')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now())
                            ->native(false),

                        DatePicker::make('endDate')
                            ->label('End Date')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now())
                            ->native(false),

                        Select::make('status_id')
                            ->label('Status')
                            ->options(Status::where('status_type_id', 3)->pluck('name', 'id')->toArray())
                            ->searchable(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->visible(fn ($record) => 
                        in_array(Auth::user()?->roles?->first()?->name ?? '', ['super_admin', 'employee']) 
                        ),
            ]);
    }
}
