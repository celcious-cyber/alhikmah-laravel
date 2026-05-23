<?php

namespace App\Filament\Resources\Beasiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_registrasi')
                    ->searchable(),
                TextColumn::make('jenis_beasiswa')
                    ->searchable(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('tempat_lahir')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->searchable(),
                TextColumn::make('email_pendaftar')
                    ->searchable(),
                TextColumn::make('telepon')
                    ->searchable(),
                TextColumn::make('asal_sekolah')
                    ->searchable(),
                TextColumn::make('file_sertifikat')
                    ->searchable(),
                TextColumn::make('file_sk_hafalan')
                    ->searchable(),
                TextColumn::make('file_sktm')
                    ->searchable(),
                TextColumn::make('file_rekomendasi')
                    ->searchable(),
                TextColumn::make('file_komitmen')
                    ->searchable(),
                IconColumn::make('verified')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
