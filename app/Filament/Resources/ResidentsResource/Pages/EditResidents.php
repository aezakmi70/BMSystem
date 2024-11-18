<?php

namespace App\Filament\Resources\ResidentsResource\Pages;

use App\Filament\Resources\ResidentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResidents extends EditRecord
{
    protected static string $resource = ResidentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
