<?php

namespace App\Filament\Resources\ResidentsResource\Pages;

use App\Filament\Resources\ResidentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\PopulationOverview;

class ListResidents extends ListRecords
{
    protected static string $resource = ResidentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Register Residents'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
           PopulationOverview::class
        ];
    }
}
