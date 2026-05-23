<?php

namespace App\Filament\Resources\Alumni\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumnusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Alumni')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('graduation_year')
                            ->label('Tahun Lulus / Angkatan')
                            ->numeric()
                            ->required(),
                        TextInput::make('university')
                            ->label('Universitas')
                            ->required()
                            ->maxLength(255),
                        Select::make('country')
                            ->label('Negara')
                            ->required()
                            ->options([
                                'Indonesia' => 'Indonesia',
                                'Mesir' => 'Mesir',
                                'Turki' => 'Turki',
                                'Arab Saudi' => 'Arab Saudi',
                                'Malaysia' => 'Malaysia',
                                'Maroko' => 'Maroko',
                                'Yaman' => 'Yaman',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->default('Indonesia'),
                        TextInput::make('major')
                            ->label('Jurusan / Prodi')
                            ->maxLength(255),
                        TextInput::make('profession')
                            ->label('Profesi / Pekerjaan Saat Ini')
                            ->maxLength(255),
                        Textarea::make('testimony')
                            ->label('Testimoni / Kesan Pesan')
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('alumni')
                            ->columnSpanFull(),
                        Toggle::make('is_featured')
                            ->label('Jadikan Highlight (Tampil di atas)')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
