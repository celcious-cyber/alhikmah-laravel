<?php

namespace App\Filament\Resources\Pendaftarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PendaftaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_registrasi'),
                TextInput::make('email_pendaftar')
                    ->email(),
                TextInput::make('nama_lengkap')
                    ->required(),
                TextInput::make('tempat_lahir'),
                TextInput::make('tanggal_lahir'),
                TextInput::make('jenis_kelamin'),
                TextInput::make('nisn'),
                TextInput::make('nik'),
                TextInput::make('agama'),
                TextInput::make('hobi'),
                TextInput::make('cita_cita'),
                TextInput::make('anak_ke'),
                TextInput::make('jumlah_saudara_kandung'),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                TextInput::make('rt_rw'),
                TextInput::make('dusun'),
                TextInput::make('desa'),
                TextInput::make('kecamatan'),
                TextInput::make('kabupaten'),
                TextInput::make('provinsi'),
                TextInput::make('kode_pos'),
                TextInput::make('no_kk'),
                TextInput::make('kepala_keluarga'),
                TextInput::make('nama_ayah_kandung'),
                TextInput::make('status_ayah'),
                Textarea::make('alamat_ayah')
                    ->columnSpanFull(),
                TextInput::make('nik_ayah'),
                TextInput::make('pekerjaan_ayah'),
                TextInput::make('nama_ibu_kandung'),
                TextInput::make('status_ibu'),
                TextInput::make('nik_ibu'),
                TextInput::make('pekerjaan_ibu'),
                Textarea::make('alamat_ibu')
                    ->columnSpanFull(),
                TextInput::make('nama_wali'),
                TextInput::make('nik_wali'),
                Textarea::make('alamat_wali')
                    ->columnSpanFull(),
                TextInput::make('penghasilan'),
                TextInput::make('no_kks'),
                TextInput::make('no_pkh'),
                TextInput::make('no_kip'),
                TextInput::make('asal_sekolah'),
                TextInput::make('npsn_sekolah'),
                Textarea::make('alamat_sekolah')
                    ->columnSpanFull(),
                TextInput::make('no_surat_lulus'),
                TextInput::make('no_blangko_ijazah'),
                TextInput::make('nilai_rata2_ijazah'),
                TextInput::make('foto_3x4'),
                TextInput::make('file_ijazah'),
                TextInput::make('file_surat_lulus'),
                TextInput::make('file_akte_lahir'),
                TextInput::make('file_kk'),
                TextInput::make('file_kartu_nisn'),
                TextInput::make('file_kartu_kip'),
                TextInput::make('file_kartu_pkh'),
                TextInput::make('file_kartu_kks'),
                TextInput::make('file_foto_rapot'),
                Toggle::make('verified')
                    ->required(),
                TextInput::make('verified_by'),
            ]);
    }
}
