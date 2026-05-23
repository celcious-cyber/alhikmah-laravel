<?php

namespace App\Filament\Resources\Beasiswas;

use App\Filament\Resources\Beasiswas\Pages\CreateBeasiswa;
use App\Filament\Resources\Beasiswas\Pages\EditBeasiswa;
use App\Filament\Resources\Beasiswas\Pages\ListBeasiswas;
use App\Filament\Resources\Beasiswas\Schemas\BeasiswaForm;
use App\Filament\Resources\Beasiswas\Tables\BeasiswasTable;
use App\Models\Beasiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BeasiswaResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    protected static ?string $model = Beasiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|\UnitEnum|null $navigationGroup = 'Pendaftaran & PSB';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Pengajuan Beasiswa';

    public static function form(Schema $schema): Schema
    {
        return BeasiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeasiswasTable::configure($table);
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
            'index' => ListBeasiswas::route('/'),
            'create' => CreateBeasiswa::route('/create'),
            'edit' => EditBeasiswa::route('/{record}/edit'),
        ];
    }
}
