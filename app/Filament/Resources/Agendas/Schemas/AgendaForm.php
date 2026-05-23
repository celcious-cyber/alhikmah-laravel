<?php

namespace App\Filament\Resources\Agendas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgendaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Agenda')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Kegiatan / Agenda')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Jenis Agenda')
                            ->required()
                            ->options([
                                'harian'   => 'Harian',
                                'mingguan' => 'Mingguan',
                                'bulanan'  => 'Bulanan',
                                'tahunan'  => 'Tahunan',
                            ]),
                        TextInput::make('time')
                            ->label('Waktu Pelaksanaan')
                            ->placeholder('Misal: 04:00 - 05:00 atau Setiap Kamis Sore')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil akan tampil lebih dulu'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
