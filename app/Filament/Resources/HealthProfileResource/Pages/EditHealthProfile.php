<?php

namespace App\Filament\Resources\HealthProfileResource\Pages;

use App\Filament\Resources\HealthProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthProfile extends EditRecord
{
    protected static string $resource = HealthProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
