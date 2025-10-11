<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('employe.name')
                    ->label('Employee Name'),
                TextEntry::make('roles.name')
                    ->label('Role'),
                IconEntry::make('active')
                    ->boolean(),
                
                Section::make('Data Information')
                    ->schema([
                        TextEntry::make('createdBy.name')
                            ->label('Created By'),
                        TextEntry::make('updatedBy.name')
                            ->label("Updated by"),
                        TextEntry::make('deletedBy.name')
                            ->label("Deleted by"),
                    ])->columns(3)->columnSpanFull()->collapsible(),

                Section::make('Timestamps')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d/m/Y H:i'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d/m/Y H:i'),
                            ]),
                    ])->columnSpanFull()->collapsible(),
            ]);
    }
}
