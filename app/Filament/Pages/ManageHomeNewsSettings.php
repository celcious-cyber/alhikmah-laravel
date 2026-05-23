<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use BackedEnum;
use UnitEnum;

class ManageHomeNewsSettings extends Page implements HasForms
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Website';
    protected static ?string $navigationLabel = 'Berita (Beranda)';
    protected static ?string $title = 'Berita (Beranda)';
    protected static ?int $navigationSort = 102;

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
                \Filament\Schemas\Components\Section::make('Berita (Beranda)')
                    ->schema([
                        \Filament\Forms\Components\Select::make('featured_news')
                            ->label('Pilih Berita untuk Beranda')
                            ->multiple()
                            ->options(\App\Models\News::where('isPublished', true)->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih berita spesifik yang ingin ditampilkan di beranda. Jika dikosongkan, beranda akan otomatis menampilkan 3 berita terbaru.'),
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
