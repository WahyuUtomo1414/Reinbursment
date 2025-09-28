<?php

namespace App\Filament\Resources\StatusTypes;

use App\Filament\Resources\StatusTypes\Pages\CreateStatusType;
use App\Filament\Resources\StatusTypes\Pages\EditStatusType;
use App\Filament\Resources\StatusTypes\Pages\ListStatusTypes;
use App\Filament\Resources\StatusTypes\Schemas\StatusTypeForm;
use App\Filament\Resources\StatusTypes\Tables\StatusTypesTable;
use App\Models\StatusType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class StatusTypeResource extends Resource
{
    protected static ?string $model = StatusType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;

    protected static ?string $navigationLabel = 'Status Type';

    protected static ?string $recordTitleAttribute = 'StatusType';

    protected static string | UnitEnum | null $navigationGroup = 'Data Master';

    public static function form(Schema $schema): Schema
    {
        return StatusTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatusTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatusTypes::route('/'),
            'create' => CreateStatusType::route('/create'),
            'edit' => EditStatusType::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
