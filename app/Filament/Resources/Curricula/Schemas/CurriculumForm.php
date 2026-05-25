<?php

namespace App\Filament\Resources\Curricula\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class CurriculumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ─── Informasi Umum ───────────────────────────────
                Section::make('Informasi Umum Lembaga')
                    ->icon('heroicon-o-building-library')
                    ->collapsible()
                    ->schema([
                        Select::make('type')
                            ->label('Jenis Lembaga')
                            ->required()
                            ->options([
                                'kmi' => "KMI (Kulliyatul Mu'allimin Al-Islamiyah)",
                                'smp' => 'SMP Al-Hikmah',
                                'ma'  => 'MA Al-Hikmah (Madrasah Aliyah)',
                                'tpq' => 'TPQ Al-Hikmah',
                            ]),
                        TextInput::make('name')
                            ->label('Nama Resmi Lembaga')
                            ->required(),
                        TextInput::make('tagline')
                            ->label('Tagline / Slogan'),
                        TextInput::make('year_established')
                            ->label('Tahun Berdiri')
                            ->numeric(),
                        TextInput::make('total_students')
                            ->label('Jumlah Santri/Siswa')
                            ->numeric(),
                        TextInput::make('total_teachers')
                            ->label('Jumlah Pengajar/Guru')
                            ->numeric(),
                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->default(fn () => \App\Models\Curriculum::max('order') + 1),
                    ])->columns(2),

                // ─── Kepala Lembaga ───────────────────────────────
                Section::make('Kepala Lembaga')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->schema([
                        TextInput::make('head_name')
                            ->label('Nama Kepala Lembaga'),
                        TextInput::make('head_title')
                            ->label('Gelar / Jabatan'),
                        FileUpload::make('head_photo')
                            ->label('Foto Kepala Lembaga')
                            ->image()
                            ->imageEditor()
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->directory('curricula/heads')
                            ->visibility('public'),
                        FileUpload::make('thumbnail')
                            ->label('Foto Banner / Thumbnail Utama')
                            ->image()
                            ->imageEditor()
                            ->imageResizeTargetWidth('1280')
                            ->directory('curricula/banners')
                            ->visibility('public'),
                    ])->columns(2),

                // ─── Data & Legalitas ────────────────────────
                Section::make('Data & Legalitas')
                    ->icon('heroicon-o-document-check')
                    ->collapsible()
                    ->schema([
                        Repeater::make('legalities')
                            ->label('Daftar Perizinan & Legalitas')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Dokumen / Izin (contoh: NPSN, Akreditasi, NSPP)')
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Nomor / Nilai (contoh: 123456, A Unggul)')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->addActionLabel('Tambah Data Legalitas')
                            ->defaultItems(0),
                        
                        FileUpload::make('background_image')
                            ->label('Foto Banner Latar Belakang (Bisa pilih lebih dari satu)')
                            ->image()
                            ->multiple()
                            ->directory('curricula-backgrounds')
                            ->columnSpanFull(),
                    ])->columns(2),

                // ─── Deskripsi & Sejarah ───────────────────────────
                Section::make('Deskripsi & Sejarah')
                    ->icon('heroicon-o-book-open')
                    ->collapsible()
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi Umum Lembaga')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('history')
                            ->label('Sejarah Berdirinya Lembaga')
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                // ─── Fitur Unggulan ───────────────────────────────
                Section::make('Fitur & Keunggulan')
                    ->icon('heroicon-o-star')
                    ->collapsible()
                    ->schema([
                        Repeater::make('features')
                            ->label('Daftar Keunggulan/Fitur')
                            ->schema([
                                TextInput::make('item')
                                    ->label('Poin Keunggulan')
                                    ->required(),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Tambah Keunggulan')
                            ->defaultItems(0),
                    ]),

                // ─── Mata Pelajaran ───────────────────────────────
                Section::make('Mata Pelajaran')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->collapsible()
                    ->schema([
                        Repeater::make('subjects')
                            ->label('Daftar Mata Pelajaran')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Mata Pelajaran')
                                    ->required(),
                                Select::make('type')
                                    ->label('Jenis')
                                    ->options([
                                        'agama' => 'Agama / Dirasah Islamiyah',
                                        'umum'  => 'Umum / Nasional',
                                        'bahasa'=> 'Bahasa',
                                        'sains' => 'Sains & Teknologi',
                                    ]),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->addActionLabel('Tambah Mata Pelajaran')
                            ->defaultItems(0),
                    ]),

                // ─── Prestasi ─────────────────────────────────────
                Section::make('Prestasi & Penghargaan')
                    ->icon('heroicon-o-trophy')
                    ->collapsible()
                    ->schema([
                        Repeater::make('achievements')
                            ->label('Daftar Prestasi')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Nama Prestasi')
                                    ->required(),
                                TextInput::make('year')
                                    ->label('Tahun')
                                    ->numeric(),
                                TextInput::make('level')
                                    ->label('Tingkat (Kab/Prov/Nas/Intl)'),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->addActionLabel('Tambah Prestasi')
                            ->defaultItems(0),
                    ]),
            ]);
    }
}
