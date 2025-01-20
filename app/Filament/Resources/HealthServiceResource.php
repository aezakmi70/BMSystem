<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthServiceResource\Pages;
use App\Models\HealthService;
use App\Models\Residents;
use App\Models\Official;
use Filament\Forms;
use App\Filament\Forms\Components\ResidentField;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class HealthServiceResource extends Resource
{
    protected static ?string $model = HealthService::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye-dropper';
    protected static ?string $navigationGroup = 'Health Management';
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                ...ResidentField::make(),

                DatePicker::make('service_date')
                    ->required(),
               Select::make('service_type')
                    ->options([
                        'Vaccination' => 'Vaccination',
                        'Consultation' => 'Consultation',
                        'Check-up' => 'Check-up',
                        'Other' => 'Other',
                    ])
                    ->required(),




                    //
                    Select::make('provided_by')
                    ->label('Recorded By')
                    ->searchable()
                    ->required()  
                    ->getSearchResultsUsing(function (string $search) {
                        return Residents::query()
                            ->where('firstname', 'like', '%' . $search . '%')
                            ->orWhere('middlename', 'like', '%' . $search . '%')
                            ->orWhere('lastname', 'like', '%' . $search . '%')
                            ->get()
                            ->mapWithKeys(function ($resident) {
                                return [$resident->id => $resident->full_name];
                            });
       
                    })                            
                    
                    ->afterStateUpdated(function ($state, callable $set) {
                        $resident = Residents::find($state);
                        $official = Official::where('resident_id', $state)->first();
                        if ($official) {
                            $set('provided_by', $resident->full_name);
                        }
                      
                    })
                    ->afterStateHydrated(function ($state, callable $set){
                        $resident = Residents::find($state);
                        $official = Official::where('resident_id', $state)->first();
                        if ($official) {
                            $set('provided_by', $resident->full_name);

                        }
                       
                    })
                    ->columnSpan(2),
                




               Select::make('status')
                    ->options([
                        'Completed' => 'Completed',
                        'Pending' => 'Pending',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Completed')
                    ->required(),
                    Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(65535)
                    ->columnSpan(2),
                    ])->columns(5),
                 ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('resident.full_name')
                ->label('Resident Name')
                ->sortable(),

                TextColumn::make('service_date')->date()->sortable(),
               TextColumn::make('service_type')->sortable(),
              TextColumn::make('status')->badge(),
               TextColumn::make('description')->limit(50),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('resident_id')
                    ->label('Resident')
                    ->visible(function () {

                        return request()->query('record') ? true : false;
                    })
                    ->query(function ($query, $state) {
                        $residentIdFromUrl = request()->query('record');
                        
                        if ($residentIdFromUrl) {
                            return $query->where('resident_id', $residentIdFromUrl);
                        }
                        return $query;
                    })
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthServices::route('/'),
            'create' => Pages\CreateHealthService::route('/create'),
            'edit' => Pages\EditHealthService::route('/{record}/edit'),
        ];
    }
}
