<?php

namespace App\Filament\Resources\Beasiswas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BeasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_registrasi'),
                TextInput::make('jenis_beasiswa')
                    ->required(),
                TextInput::make('nama_lengkap')
                    ->required(),
                TextInput::make('tempat_lahir'),
                TextInput::make('tanggal_lahir'),
                TextInput::make('email_pendaftar')
                    ->email(),
                TextInput::make('telepon')
                    ->tel(),
                TextInput::make('asal_sekolah'),
                Textarea::make('prestasi_deskripsi')
                    ->columnSpanFull(),
                TextInput::make('file_sertifikat'),
                TextInput::make('file_sk_hafalan'),
                TextInput::make('file_sktm'),
                TextInput::make('file_rekomendasi'),
                TextInput::make('file_komitmen'),
                Toggle::make('verified')
                    ->required(),
            ]);
    }
}
