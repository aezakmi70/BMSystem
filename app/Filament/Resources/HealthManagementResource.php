<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthManagementResource\Pages;
use App\Models\HealthManagement;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class HealthManagementResource extends Resource
{
    protected static ?string $model = HealthManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
                // Other form fields...

                // Adding the 'residentid' select field
                Select::make('residentName') // Store the resident's full name
                ->label('Resident Full Name')
                ->searchable()
                ->getSearchResultsUsing(function (string $search) {
                    return \App\Models\Residents::query()
                        ->where('firstname', 'like', '%'.$search.'%')
                        ->orWhere('middlename', 'like', '%'.$search.'%')
                        ->orWhere('lastname', 'like', '%'.$search.'%')
                        ->get()
                        ->mapWithKeys(function ($resident) {
                            // Concatenate first, middle, and last names for display, use ID as the key
                            return [$resident->id => $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname];
                        });
                })
                ->required()
                ->afterStateUpdated(function ($state, callable $set) {
                    // Fetch the resident's full name and ID based on the selected ID and update both 'residentid' and 'residentName'
                    $resident = \App\Models\Residents::find($state);
                    if ($resident) {
                        // Set the 'residentid' (store resident ID)
                        $set('residentid', $resident->id);
                        // Set the 'residentName' (store full name for display)
                        $set('residentName', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                    }
                }),
            
            TextInput::make('residentid') // Store the resident's ID
                ->label('Resident ID')
                ->readOnly() // Make this field readonly so it can't be edited manually
                ->required()
                ->default(fn ($get) => $get('residentid')), // Set the resident ID based on the selected resident
            
            
                TextInput::make('blood_type')
                    ->label('Blood Type')
                    ->maxLength(3)
                    ->required(),

                Textarea::make('allergies')
                    ->label('Allergies')
                    ->placeholder('Enter allergies, separated by commas')
                    ->nullable(),

                Textarea::make('medical_conditions')
                    ->label('Medical Conditions')
                    ->placeholder('Enter medical conditions, separated by commas')
                    ->nullable(),

                Forms\Components\Textarea::make('vaccination_history')
                    ->label('Vaccination History')
                    ->placeholder('Enter vaccination details as JSON')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
                ->query(HealthManagement::with('resident'))
                ->columns([
                    TextColumn::make('residentName') // Assuming you have a `completeName` accessor on the `Official` model
                    ->label('Resident Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('blood_type')
                    ->label('Blood Type')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('allergies')
                    ->label('Allergies')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('medical_conditions')
                    ->label('Medical Conditions')
                    ->limit(50)
                    ->searchable(),

                BadgeColumn::make('vaccination_history')
                    ->label('Vaccination Status')
                    ->getStateUsing(fn ($record) => $record->vaccination_history ? 'Vaccinated' : 'Not Vaccinated')
                    ->colors(['success', 'danger']),
            ])
            ->filters([
                // Define any filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthManagement::route('/'),
            'create' => Pages\CreateHealthManagement::route('/create'),
            'edit' => Pages\EditHealthManagement::route('/{record}/edit'),
        ];
    }
}
