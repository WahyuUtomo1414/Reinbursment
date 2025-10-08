<?php

namespace App\Filament\Resources\ReinbursementTRXES;

use App\Filament\Resources\ReinbursementTRXES\Pages\CreateReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Pages\EditReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Pages\ListReinbursementTRXES;
use App\Filament\Resources\ReinbursementTRXES\Pages\ViewReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Schemas\ReinbursementTRXForm;
use App\Filament\Resources\ReinbursementTRXES\Schemas\ReinbursementTRXInfolist;
use App\Filament\Resources\ReinbursementTRXES\Tables\ReinbursementTRXESTable;
use App\Models\ReinbursementTRX;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ReinbursementTRXResource extends Resource
{
    protected static ?string $model = ReinbursementTRX::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCurrencyDollar;

    protected static string | UnitEnum | null $navigationGroup = 'Data Reinbursement';

    protected static ?string $navigationLabel = 'Reinbursement';

    protected static ?string $recordTitleAttribute = 'Reinbursement';

    public static function form(Schema $schema): Schema
    {
        return ReinbursementTRXForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReinbursementTRXInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReinbursementTRXESTable::configure($table);
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
            'index' => ListReinbursementTRXES::route('/'),
            'create' => CreateReinbursementTRX::route('/create'),
            'view' => ViewReinbursementTRX::route('/{record}'),
            'edit' => EditReinbursementTRX::route('/{record}/edit'),
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
