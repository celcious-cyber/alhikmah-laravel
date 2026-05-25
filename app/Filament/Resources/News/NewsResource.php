<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\EditNews;
use App\Filament\Resources\News\Pages\ListNews;
use App\Filament\Resources\News\Schemas\NewsForm;
use App\Filament\Resources\News\Tables\NewsTable;
use App\Models\News;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isPenulis() || auth()->user()->isCurriculumAdmin() || auth()->user()->isIkph();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->isAdmin()) {
            return $query->where('author_id', auth()->id());
        }

        return $query;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static string|\UnitEnum|null $navigationGroup = 'Portal Berita';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Berita';

    public static function form(Schema $schema): Schema
    {
        return NewsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsTable::configure($table);
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
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}
