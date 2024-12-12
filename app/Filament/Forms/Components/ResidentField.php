<?php
namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use App\Models\Residents;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class ResidentField
{
    public static function make()
    {
        return [
            Section::make()
            ->schema([
            Select::make('resident_name')
                ->label('Resident Name')
                ->searchable()
                ->getSearchResultsUsing(function (string $search) {
                    return Residents::query()
                        ->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('middlename', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%')
                        ->get()
                        ->mapWithKeys(function ($resident) {
                            // Use the full_name accessor here to concatenate the names dynamically
                            return [$resident->id => $resident->full_name]; 
                        });
                })
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    // After state update (when resident_id is changed), update resident_name
                    $resident = Residents::find($state);
                    if ($resident) {
                        // Dynamically set 'resident_name' based on the resident_id
                        $set('resident_name', $resident->full_name);
                        $set('resident_id', $resident->id);
                    }
                })->columnSpan(3)
                ,

            // Displaying the full name, but it's disabled and cannot be edited
           TextInput::make('resident_id')
                ->label('Resident ID')
                ->readonly()
                ->reactive()
                ->required()
                ->default(fn () => request()->query('resident_id'))
                ->afterStateHydrated(function ($state, callable $set) {
                    if ($state) {
                        // If resident_id is set (for editing an existing record), populate resident_name
                        $resident = Residents::find($state);
                        if ($resident) {
                            $set('resident_name', $resident->full_name);
                        }
                    }
                }),
            ])->columns(4)
            ->columnSpan(3)
        ];
        
    }
}
