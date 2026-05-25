<?php

namespace App\Filament\Resources\Galleries;

use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Filament\Resources\Galleries\Schemas\GalleryForm;
use App\Filament\Resources\Galleries\Tables\GalleriesTable;
use App\Models\Gallery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GalleryResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isCurriculumAdmin() || auth()->user()->isIkph();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->isAdmin()) {
            return $query->where('author_id', auth()->id());
        }

        return $query;
    }

    protected static ?string $model = Gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;
    protected static string|\UnitEnum|null $navigationGroup = 'Media & Aktivitas';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Galeri Foto';
    protected static ?string $pluralLabel = 'Galeri';

    public static function form(Schema $schema): Schema
    {
        return GalleryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleriesTable::configure($table);
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
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
