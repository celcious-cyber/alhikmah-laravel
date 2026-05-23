<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Program')
                    ->required(),
                TextInput::make('category')
                    ->label('Kategori')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('imageUrl')
                    ->label('Gambar/Thumbnail')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('1080')
                    ->imageResizeTargetHeight('1080')
                    ->directory('programs')
                    ->visibility('public'),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
