<?php

namespace App\Filament\Resources\ResidentsResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use App\Models\HealthService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HealthServicesRelationManager extends RelationManager
{
    protected static ?string $model = HealthService::class;

    protected static string $relationship = 'healthServices';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('resident.full_name') // Access the full_name from the Resident model
                ->label('Resident Name')
                ->sortable(),
                TextColumn::make('service_date')->date()->sortable(),
                TextColumn::make('service_type'),
                TextColumn::make('status')->badge(),
                TextColumn::make('description')->limit(50),
            ])
            
            ->headerActions([
                
                Tables\Actions\Action::make('createHealthProfile')
                    ->label('Create Health Service')
                    ->icon('heroicon-o-plus')
                    ->url(fn () => route('filament.admin.resources.health-services.create', [
                        'resident_id' => $this->ownerRecord->id, 
                    ]))
                    ->openUrlInNewTab()
                    
            ])
            ->actions([
                
                Tables\Actions\Action::make('viewDetails')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->url(fn (HealthService $record): string => route('filament.admin.resources.health-services.index', [
                        'record' => $record->resident_id,
                    ]))
                    ->openUrlInNewTab(), 
                    ]);
           
                    }
 
}
