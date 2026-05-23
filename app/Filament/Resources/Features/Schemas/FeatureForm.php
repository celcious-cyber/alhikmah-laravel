<?php

namespace App\Filament\Resources\Features\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_id')
                    ->label('Judul (ID)')
                    ->required(),
                \Filament\Forms\Components\Textarea::make('desc_id')
                    ->label('Deskripsi (ID)')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title_en')
                    ->label('Judul (EN)'),
                \Filament\Forms\Components\Textarea::make('desc_en')
                    ->label('Deskripsi (EN)')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('icon')
                    ->label('Ikon')
                    ->options([
                        'BookOpen' => 'Buku Terbuka (BookOpen)',
                        'BookMarked' => 'Buku Ditandai (BookMarked)',
                        'Building' => 'Bangunan (Building)',
                        'Users' => 'Pengguna (Users)',
                        'Moon' => 'Bulan (Moon)',
                        'Trophy' => 'Piala (Trophy)',
                        'Star' => 'Bintang (Star)',
                        'Heart' => 'Hati (Heart)',
                        'CheckCircle' => 'Centang (CheckCircle)',
                        'Shield' => 'Perisai (Shield)',
                    ])
                    ->searchable()
                    ->required()
                    ->default('BookOpen'),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
