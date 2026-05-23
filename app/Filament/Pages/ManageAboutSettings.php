<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use BackedEnum;
use UnitEnum;

class ManageAboutSettings extends Page implements HasForms
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Website';
    protected static ?string $navigationLabel = 'Tentang Kami (Beranda)';
    protected static ?string $title = 'Tentang Kami (Beranda)';
    protected static ?int $navigationSort = 101;

    protected string $view = 'filament.pages.manage-settings';

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
                \Filament\Schemas\Components\Section::make('Tentang Kami (Beranda)')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('about_image')
                            ->label('Foto Pendiri / Pimpinan')
                            ->image()
                            ->directory('settings'),
                        TextInput::make('founder_name')->label('Nama Pendiri / Pimpinan')->default('KH. Syihabuddin Muhammad'),
                        TextInput::make('founder_title')->label('Gelar / Jabatan')->default('Pendiri & Pengasuh Pondok Pesantren Modern Al-Hikmah'),
                        TextInput::make('about_title')->label('Judul Utama')->default('Tentang Al-Hikmah'),
                        TextInput::make('about_subtitle')->label('Sub Judul')->default('Pilar Kebangkitan Ummat'),
                        \Filament\Forms\Components\RichEditor::make('about_p1')->label('Paragraf 1 (Sejarah/Visi)'),
                        \Filament\Forms\Components\RichEditor::make('about_p2')->label('Paragraf 2 (Misi/Metode)'),
                        Textarea::make('quote_text')->label('Kutipan (Quote)'),
                        TextInput::make('quote_source')->label('Sumber Kutipan')->default('(Q.S. Al-Baqarah : 269)'),
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
