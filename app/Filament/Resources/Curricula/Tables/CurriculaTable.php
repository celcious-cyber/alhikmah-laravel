<?php

namespace App\Filament\Resources\Curricula\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class CurriculaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Banner'),
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kmi' => 'warning',
                        'smp' => 'info',
                        'ma'  => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Lembaga')
                    ->searchable(),
                TextColumn::make('accreditation')
                    ->label('Akreditasi')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'A'    => 'success',
                        'B'    => 'warning',
                        'C'    => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                TextColumn::make('total_students')
                    ->label('Santri/Siswa')
                    ->numeric(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
