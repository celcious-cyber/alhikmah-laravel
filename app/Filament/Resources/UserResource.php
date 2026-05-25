<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use BackedEnum;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Website';
    protected static ?string $navigationLabel = 'Manajemen Akun';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?int $navigationSort = 100;

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Peran (Role)')
                    ->options([
                        'admin' => 'Administrator',
                        'penulis' => 'Penulis',
                        'kmi' => 'Admin KMI',
                        'smp' => 'Admin SMP',
                        'ma' => 'Admin MA',
                        'tpq' => 'Admin TPQ',
                        'ikph' => 'Admin IKPH',
                    ])
                    ->required()
                    ->default('admin'),
                Forms\Components\TextInput::make('title')
                    ->label('Jabatan')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('avatar_url')
                    ->label('Foto Profil (Avatar)')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->directory('avatars')
                    ->maxSize(2048)
                    ->avatar(),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bio')
                    ->label('Bio Singkat')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=154D6E&color=fff'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'penulis' => 'warning',
                        'kmi', 'smp', 'ma', 'tpq', 'ikph' => 'success',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Jabatan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
