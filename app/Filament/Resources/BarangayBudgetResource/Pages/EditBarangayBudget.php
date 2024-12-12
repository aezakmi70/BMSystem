<?php

namespace App\Filament\Resources\BarangayBudgetResource\Pages;

use App\Filament\Resources\BarangayBudgetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangayBudget extends EditRecord
{
    protected static string $resource = BarangayBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
