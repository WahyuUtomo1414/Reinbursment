<?php

namespace App\Filament\Resources\ReinbursementTRXES;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\ReinbursementTRX;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\ReinburmentOverview;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReinbursementTRXES\Pages\EditReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Pages\ViewReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Pages\CreateReinbursementTRX;
use App\Filament\Resources\ReinbursementTRXES\Pages\ListReinbursementTRXES;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource\Widgets\ReinburmentOverview as WidgetsReinburmentOverview;
use App\Filament\Resources\ReinbursementTRXES\Schemas\ReinbursementTRXForm;
use App\Filament\Resources\ReinbursementTRXES\Tables\ReinbursementTRXESTable;
use App\Filament\Resources\ReinbursementTRXES\Schemas\ReinbursementTRXInfolist;

class ReinbursementTRXResource extends Resource
{
    protected static ?string $model = ReinbursementTRX::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCurrencyDollar;

    protected static string | UnitEnum | null $navigationGroup = 'Data Reinbursement';

    protected static ?string $navigationLabel = 'Reinbursement';

    protected static ?string $pluralModelLabel = 'Reinbursement';

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);

        if (!Auth::check()) {
            return $query->whereRaw('1=0');
        }

        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('super_admin', $roles) || in_array('finance', $roles)) {
            return $query;
        }

        if (in_array('division-master', $roles)) {
            $userDivisionId = $user->employe?->id_division;

            if ($userDivisionId) {
                $query->whereHas('createdBy.employe', function ($q) use ($userDivisionId) {
                    $q->where('id_division', $userDivisionId);
                });
            } else {
                $query->whereRaw('1=0');
            }

            return $query;
        }

        return $query->where('created_by', $user->id);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getWidgets(): array
    {
        return [
            WidgetsReinburmentOverview::class,
        ];
    }
}
