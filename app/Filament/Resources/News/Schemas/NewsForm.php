<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('author_id')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->default(fn () => auth()->id())
                    ->disabled(fn () => !auth()->user()->isAdmin())
                    ->dehydrated()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn ($state, \Filament\Schemas\Components\Utilities\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state ?? ''))),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('excerpt')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\RichEditor::make('content')
                    ->label('Konten Berita')
                    ->required()
                    ->live(debounce: 1000)
                    ->afterStateUpdated(function ($state, \Filament\Schemas\Components\Utilities\Set $set) {
                        $set('excerpt', \Illuminate\Support\Str::limit(strip_tags($state ?? ''), 160, '...'));
                    })
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('thumbnail')
                    ->label('Thumbnail Berita')
                    ->image()
                    ->directory('news')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('categories')
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->preload()
                    ->columnSpanFull(),
                Toggle::make('isPublished')
                    ->required()
                    ->hidden(fn () => !auth()->user()->isAdmin()),
                DateTimePicker::make('createdAt')
                    ->label('Tanggal Pembuatan / Rilis')
                    ->default(now())
                    ->required(),
                DateTimePicker::make('updatedAt')
                    ->label('Tanggal Update Terakhir')
                    ->default(now())
                    ->hiddenOn('create')
                    ->required(),
            ]);
    }
}
