<?php

namespace App\Filament\Resources\Alumni\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class AlumniTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('graduation_year')
                    ->label('Angkatan')
                    ->sortable(),
                TextColumn::make('university')
                    ->label('Universitas')
                    ->searchable(),
                TextColumn::make('country')
                    ->label('Negara')
                    ->badge()
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->label('Highlight')
                    ->boolean(),
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
            ])
            ->defaultSort('graduation_year', 'desc');
    }
}
