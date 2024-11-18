<?php

namespace App\Filament\Resources\BlotterRecordsResource\Pages;

use App\Filament\Resources\BlotterRecordsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlotterRecords extends EditRecord
{
    protected static string $resource = BlotterRecordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
