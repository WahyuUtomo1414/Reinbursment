<?php

namespace App\Filament\Resources\Users;

use UnitEnum;
use BackedEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Users\Schemas\UserInfolist;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    protected static ?string $navigationLabel = 'User';

    protected static ?string $recordTitleAttribute = 'User';

    protected static string | UnitEnum | null $navigationGroup = 'Data User';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);

        // jika bukan super admin, batasi hanya user sendiri
        if (Auth::check()) {
            if (Auth::user()->roles !== 'Super Admin') {
                $query->where('id', Auth::id());
            }
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
