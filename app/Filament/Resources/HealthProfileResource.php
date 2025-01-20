<?php

namespace App\Filament\Resources;

use App\Models\HealthProfile;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Filament\Forms\Components\ResidentField;
use App\Filament\Resources\HealthProfileResource\Pages;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class HealthProfileResource extends Resource
{
    protected static ?string $model = HealthProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Health Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
            Section::make()
                     ->schema([

                ...ResidentField::make(),
                         
                Select::make('blood_type')
                ->label('Blood Type')
                ->required()
                ->options([
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                    'Unknown' => 'Unknown', // Option for unknown blood type
                ])
                ->placeholder('Select Blood Type') // Optional placeholder
                ->default('Unknown'), // Default option if nothing is selected
                ]), 
            Section::make()
            ->schema([

                Textarea::make('allergies')
                    ->label('Allergies')
                    ->columnSpan(2)
                    ->rows(2)
                    ->maxLength(65535),
                Textarea::make('medical_conditions')
                    ->label('Medical Conditions')
                    ->rows(2)
                    ->columnSpan(2)
                    ->maxLength(65535),

                     ])->columns(4),
                     ])->columns(4), ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('resident.full_name')
                    ->label('Resident Name'),

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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations here, if needed.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthProfiles::route('/'),
            'create' => Pages\CreateHealthProfile::route('/create'),
            'edit' => Pages\EditHealthProfile::route('/{record}/edit'),
        ];
    }
}
