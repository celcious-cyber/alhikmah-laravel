<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\News;

class LatestNews extends TableWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        $query = News::query()->latest('createdAt')->limit(5);
        if (!auth()->user()->isAdmin()) {
            $query->where('author_id', auth()->id());
        }

        return $table
            ->query(fn (): Builder => $query)
            ->heading('Berita Terbaru')
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail'),
                TextColumn::make('title')
                    ->label('Judul')
                    ->limit(50),
                TextColumn::make('author.name')
                    ->label('Penulis'),
                IconColumn::make('isPublished')
                    ->label('Terbit')
                    ->boolean(),
                TextColumn::make('createdAt')
                    ->label('Tanggal')
                    ->date(),
            ])
            ->paginated(false)
            ->actions([
                \Filament\Actions\Action::make('edit')
                    ->label('Edit')
                    ->url(fn (News $record): string => \App\Filament\Resources\News\NewsResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-pencil-square'),
            ]);
    }
}
