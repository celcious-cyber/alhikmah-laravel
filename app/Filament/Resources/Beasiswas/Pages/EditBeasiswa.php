<?php

namespace App\Filament\Resources\Beasiswas\Pages;

use App\Filament\Resources\Beasiswas\BeasiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBeasiswa extends EditRecord
{
    protected static string $resource = BeasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
