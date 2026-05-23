<?php

namespace App\Filament\Resources\Agendas\Pages;

use App\Filament\Resources\Agendas\AgendaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgendas extends ListRecords
{
    protected static string $resource = AgendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => \Filament\Schemas\Components\Tabs\Tab::make('Semua'),
            'harian' => \Filament\Schemas\Components\Tabs\Tab::make('Harian')
                ->modifyQueryUsing(fn ($query) => $query->where('type', 'harian')),
            'mingguan' => \Filament\Schemas\Components\Tabs\Tab::make('Mingguan')
                ->modifyQueryUsing(fn ($query) => $query->where('type', 'mingguan')),
            'bulanan' => \Filament\Schemas\Components\Tabs\Tab::make('Bulanan')
                ->modifyQueryUsing(fn ($query) => $query->where('type', 'bulanan')),
            'tahunan' => \Filament\Schemas\Components\Tabs\Tab::make('Tahunan')
                ->modifyQueryUsing(fn ($query) => $query->where('type', 'tahunan')),
        ];
    }
}
