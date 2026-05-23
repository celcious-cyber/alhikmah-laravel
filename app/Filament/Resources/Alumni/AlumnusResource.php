<?php

namespace App\Filament\Resources\Alumni;

use App\Filament\Resources\Alumni\Pages\CreateAlumnus;
use App\Filament\Resources\Alumni\Pages\EditAlumnus;
use App\Filament\Resources\Alumni\Pages\ListAlumni;
use App\Filament\Resources\Alumni\Schemas\AlumnusForm;
use App\Filament\Resources\Alumni\Tables\AlumniTable;
use App\Models\Alumnus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlumnusResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    protected static ?string $model = Alumnus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|\UnitEnum|null $navigationGroup = 'Alumni & Tokoh';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Data Alumni';
    protected static ?string $pluralLabel = 'Alumni';

    public static function form(Schema $schema): Schema
    {
        return AlumnusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumniTable::configure($table);
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
            'index' => ListAlumni::route('/'),
            'create' => CreateAlumnus::route('/create'),
            'edit' => EditAlumnus::route('/{record}/edit'),
        ];
    }
}
