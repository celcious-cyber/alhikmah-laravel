<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use BackedEnum;

class ManageAlumniStats extends Page implements HasForms
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|\UnitEnum|null $navigationGroup = 'Alumni & Tokoh';
    protected static ?string $navigationLabel = 'Jumlah Alumni';
    protected static ?string $title = 'Pengaturan Jumlah Alumni';
    protected static ?int $navigationSort = 101;

    protected string $view = 'filament.pages.manage-alumni-stats';

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
                Section::make('Statistik Alumni')
                    ->description('Atur jumlah total alumni yang akan ditampilkan di halaman depan (Kosongkan jika ingin sistem menghitung otomatis dari jumlah Data Alumni di tabel)')
                    ->schema([
                        TextInput::make('total_alumni_putra')
                            ->label('Jumlah Alumni Putra')
                            ->numeric()
                            ->placeholder('Contoh: 800'),
                        TextInput::make('total_alumni_putri')
                            ->label('Jumlah Alumni Putri')
                            ->numeric()
                            ->placeholder('Contoh: 700'),
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
            if ($value === null || $value === '') {
                 DB::table('Settings')->where('key', $key)->delete();
            } else {
                DB::table('Settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updatedAt' => now()]
                );
            }
        }
        
        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
