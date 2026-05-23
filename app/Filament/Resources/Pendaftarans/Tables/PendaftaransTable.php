<?php

namespace App\Filament\Resources\Pendaftarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PendaftaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_registrasi')
                    ->searchable(),
                TextColumn::make('email_pendaftar')
                    ->searchable(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('tempat_lahir')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable(),
                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('nik')
                    ->searchable(),
                TextColumn::make('agama')
                    ->searchable(),
                TextColumn::make('hobi')
                    ->searchable(),
                TextColumn::make('cita_cita')
                    ->searchable(),
                TextColumn::make('anak_ke')
                    ->searchable(),
                TextColumn::make('jumlah_saudara_kandung')
                    ->searchable(),
                TextColumn::make('rt_rw')
                    ->searchable(),
                TextColumn::make('dusun')
                    ->searchable(),
                TextColumn::make('desa')
                    ->searchable(),
                TextColumn::make('kecamatan')
                    ->searchable(),
                TextColumn::make('kabupaten')
                    ->searchable(),
                TextColumn::make('provinsi')
                    ->searchable(),
                TextColumn::make('kode_pos')
                    ->searchable(),
                TextColumn::make('no_kk')
                    ->searchable(),
                TextColumn::make('kepala_keluarga')
                    ->searchable(),
                TextColumn::make('nama_ayah_kandung')
                    ->searchable(),
                TextColumn::make('status_ayah')
                    ->searchable(),
                TextColumn::make('nik_ayah')
                    ->searchable(),
                TextColumn::make('pekerjaan_ayah')
                    ->searchable(),
                TextColumn::make('nama_ibu_kandung')
                    ->searchable(),
                TextColumn::make('status_ibu')
                    ->searchable(),
                TextColumn::make('nik_ibu')
                    ->searchable(),
                TextColumn::make('pekerjaan_ibu')
                    ->searchable(),
                TextColumn::make('nama_wali')
                    ->searchable(),
                TextColumn::make('nik_wali')
                    ->searchable(),
                TextColumn::make('penghasilan')
                    ->searchable(),
                TextColumn::make('no_kks')
                    ->searchable(),
                TextColumn::make('no_pkh')
                    ->searchable(),
                TextColumn::make('no_kip')
                    ->searchable(),
                TextColumn::make('asal_sekolah')
                    ->searchable(),
                TextColumn::make('npsn_sekolah')
                    ->searchable(),
                TextColumn::make('no_surat_lulus')
                    ->searchable(),
                TextColumn::make('no_blangko_ijazah')
                    ->searchable(),
                TextColumn::make('nilai_rata2_ijazah')
                    ->searchable(),
                TextColumn::make('foto_3x4')
                    ->searchable(),
                TextColumn::make('file_ijazah')
                    ->searchable(),
                TextColumn::make('file_surat_lulus')
                    ->searchable(),
                TextColumn::make('file_akte_lahir')
                    ->searchable(),
                TextColumn::make('file_kk')
                    ->searchable(),
                TextColumn::make('file_kartu_nisn')
                    ->searchable(),
                TextColumn::make('file_kartu_kip')
                    ->searchable(),
                TextColumn::make('file_kartu_pkh')
                    ->searchable(),
                TextColumn::make('file_kartu_kks')
                    ->searchable(),
                TextColumn::make('file_foto_rapot')
                    ->searchable(),
                IconColumn::make('verified')
                    ->boolean(),
                TextColumn::make('verified_by')
                    ->searchable(),
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
