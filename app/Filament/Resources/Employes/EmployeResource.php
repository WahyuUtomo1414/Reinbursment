<?php

namespace App\Filament\Resources\Employes;

use UnitEnum;
use BackedEnum;
use App\Models\Employe;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Employes\Pages\EditEmploye;
use App\Filament\Resources\Employes\Pages\ViewEmploye;
use App\Filament\Resources\Employes\Pages\ListEmployes;
use App\Filament\Resources\Employes\Pages\CreateEmploye;
use App\Filament\Resources\Employes\Schemas\EmployeForm;
use App\Filament\Resources\Employes\Tables\EmployesTable;
use App\Filament\Resources\Employes\Schemas\EmployeInfolist;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $navigationLabel = 'Employe';

    protected static ?string $recordTitleAttribute = 'Employe';

    protected static string | UnitEnum | null $navigationGroup = 'Data Employe';

    public static function form(Schema $schema): Schema
    {
        return EmployeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmployeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployesTable::configure($table);
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
            'index' => ListEmployes::route('/'),
            'create' => CreateEmploye::route('/create'),
            'view' => ViewEmploye::route('/{record}'),
            'edit' => EditEmploye::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);

        if (Auth::check()) {
            $user = Auth::user();
            $roleName = $user?->roles?->first()?->name ?? '';

            if ($roleName !== 'super_admin') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('id', $user->id);
                });
            }
        }

        return $query;
    }
}
