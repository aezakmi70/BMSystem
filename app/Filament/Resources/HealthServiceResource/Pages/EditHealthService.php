<?php

namespace App\Filament\Resources\HealthServiceResource\Pages;

use App\Filament\Resources\HealthServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthService extends EditRecord
{
    protected static string $resource = HealthServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
