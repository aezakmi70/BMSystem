<?php

namespace App\Filament\Resources\HealthManagementResource\Pages;

use App\Filament\Resources\HealthManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthManagement extends ListRecords
{
    protected static string $resource = HealthManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
