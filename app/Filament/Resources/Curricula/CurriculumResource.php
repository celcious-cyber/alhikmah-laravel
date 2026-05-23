<?php

namespace App\Filament\Resources\Curricula;

use App\Filament\Resources\Curricula\Pages\CreateCurriculum;
use App\Filament\Resources\Curricula\Pages\EditCurriculum;
use App\Filament\Resources\Curricula\Pages\ListCurricula;
use App\Filament\Resources\Curricula\Schemas\CurriculumForm;
use App\Filament\Resources\Curricula\Tables\CurriculaTable;
use App\Models\Curriculum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CurriculumResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    protected static ?string $model = Curriculum::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static string|\UnitEnum|null $navigationGroup = 'Profil Pesantren';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Kurikulum (KMI/SMP/MA)';
    protected static ?string $pluralLabel = 'Kurikulum';

    public static function form(Schema $schema): Schema
    {
        return CurriculumForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CurriculaTable::configure($table);
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
            'index' => ListCurricula::route('/'),
            'create' => CreateCurriculum::route('/create'),
            'edit' => EditCurriculum::route('/{record}/edit'),
        ];
    }
}
