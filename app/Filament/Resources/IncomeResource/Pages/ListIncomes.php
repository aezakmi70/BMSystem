<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;


class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;
    protected function getHeaderActions(): array
    {
        $currentView = session()->get('incomes_view', 'income'); // Get the current view from the session
    
        // Return the CreateAction only if the view is 'income', otherwise return an empty array
        return $currentView === 'income' 
            ? [Actions\CreateAction::make()] 
            : [];
    }

}
