<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Fasilitas')
                    ->required(),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('imageUrl')
                    ->label('Foto Fasilitas')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('1080')
                    ->imageResizeTargetHeight('1080')
                    ->directory('facilities')
                    ->visibility('public')
                    ->required(),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
