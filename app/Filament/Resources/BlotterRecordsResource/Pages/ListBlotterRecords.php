<?php

namespace App\Filament\Resources\BlotterRecordsResource\Pages;

use App\Filament\Resources\BlotterRecordsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlotterRecords extends ListRecords
{
    protected static string $resource = BlotterRecordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
