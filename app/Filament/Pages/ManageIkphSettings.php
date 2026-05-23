<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use BackedEnum;

class ManageIkphSettings extends Page implements HasForms
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static string|\UnitEnum|null $navigationGroup = 'Alumni & Tokoh';
    protected static ?string $navigationLabel = 'Pengaturan Banner IKPH';
    protected static ?string $title = 'Pengaturan Banner IKPH';
    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.manage-ikph-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = DB::table('Settings')->pluck('value', 'key')->map(function ($value) {
            $decoded = json_decode($value, true);
            return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : $value;
        })->toArray();
        $this->form->fill($settings);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Banner Halaman IKPH')
                    ->description('Atur gambar latar belakang yang akan ditampilkan di halaman IKPH')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('ikph_background_image')
                            ->label('Foto Banner Latar Belakang (Bisa pilih lebih dari satu)')
                            ->image()
                            ->multiple()
                            ->directory('settings'),
                    ])
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            DB::table('Settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updatedAt' => now()]
            );
        }
        
        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
