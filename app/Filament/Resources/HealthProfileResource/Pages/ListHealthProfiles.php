<?php

namespace App\Filament\Resources\HealthProfileResource\Pages;

use App\Filament\Resources\HealthProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthProfiles extends ListRecords
{
    protected static string $resource = HealthProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Health Profile'),
        ];
    }
}
