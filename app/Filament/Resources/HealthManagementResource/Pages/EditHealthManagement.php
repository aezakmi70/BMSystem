<?php

namespace App\Filament\Resources\HealthManagementResource\Pages;

use App\Filament\Resources\HealthManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthManagement extends EditRecord
{
    protected static string $resource = HealthManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
