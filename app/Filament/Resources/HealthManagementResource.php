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

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
                // Other form fields...

                // Adding the 'residentid' select field
                Select::make('residentid')
    ->label('Resident')
    ->options(function () {
        return \App\Models\Residents::select('id', 'firstname', 'middlename', 'lastname')->get()
            ->mapWithKeys(function ($resident) {
                // Concatenate the full name from the selected columns
                $fullname = trim($resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                return [$resident->id => $fullname];
            });
    })
    ->transformOptionsForJsUsing(static function (Forms\Components\Select $component, array $options): array {
        return collect($options)
            ->map(fn ($label, $value): array => is_array($label)
                ? ['label' => $value, 'choices' => $component->transformOptionsForJs($label)]
                : ['label' => $label, 'value' => strval($value), 'disabled' => $component->isOptionDisabled($value, $label)])
            ->values()
            ->all();
    })
    ->searchable()
    ->required(),

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
            ->columns([
                TextColumn::make('resident.fullname')
                    ->label('Resident')
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
