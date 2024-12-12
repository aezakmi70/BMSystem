<?php

namespace App\Filament\Resources\BarangayBudgetResource\Pages;

use App\Filament\Resources\BarangayBudgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangayBudgets extends ListRecords
{
    protected static string $resource = BarangayBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
