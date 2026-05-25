<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('imageUrl')
                    ->label('Gambar')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('1080')
                    ->imageResizeTargetHeight('1080')
                    ->directory('galleries')
                    ->visibility('public')
                    ->required(),
                TextInput::make('caption')->label('Keterangan'),
                \Filament\Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options(function () {
                        return \App\Models\GalleryCategory::pluck('name', 'slug')->toArray();
                    })
                    ->required()
                    ->native(false) // Use nice custom dropdown UI instead of native OS dropdown
                    ->searchable() // Allow searching through categories
                    ->preload(),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                \Filament\Forms\Components\Hidden::make('author_id')
                    ->default(fn () => auth()->id()),
            ]);
    }
}
