<?php

namespace App\Filament\Resources\ResidentsResource\RelationManagers;

use App\Models\HealthProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HealthProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'healthProfile';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('resident_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('resident_id')
            ->columns([
                TextColumn::make('resident.firstname')
                ->label('First Name'),
            TextColumn::make('resident.lastname')
                ->label('Last Name'),
            TextColumn::make('blood_type')
                ->label('Blood Type'),
            TextColumn::make('allergies')
                ->label('Allergies')
                ->limit(50),
            TextColumn::make('medical_conditions')
                ->label('Medical Conditions')
                ->limit(50),
            TextColumn::make('healthServices.description')
                ->label('Vaccination History')
                ->limit(50)
                ->default('None'),
            ])
            ->headerActions([
                
                Tables\Actions\Action::make('createHealthProfile')
                    ->label('Create Health Profile')
                    ->icon('heroicon-o-plus')
                    ->url(fn () => route('filament.admin.resources.health-profiles.create', [
                        'resident_id' => $this->ownerRecord->id, 
                    ]))
                    ->openUrlInNewTab()
                    ->visible(function () {
                        
                        $existingProfile = HealthProfile::where('resident_id', $this->ownerRecord->id)->exists();
                        return !$existingProfile; 
                    }),
            ])
           
            ->actions([

                Tables\Actions\Action::make('viewDetails')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->url(fn (HealthProfile $record): string => route('filament.admin.resources.health-profiles.edit', [
                        'record' => $record->id,
                    ]))
                    ->openUrlInNewTab(), 
                    ]);
           
           
    }
}
