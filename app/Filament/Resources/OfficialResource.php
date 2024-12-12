<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficialResource\Pages;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Official;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use App\Models\Residents; 
use Filament\Forms\Components\Section;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Barangay'; 
    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Official Information')
                ->schema([
                Section::make('Official Information')
                ->schema([
                Select::make('resident_name')
                    ->label('Official Name')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return Residents::query()
                            ->where('firstname', 'like', '%'.$search.'%')
                            ->orWhere('middlename', 'like', '%'.$search.'%')
                            ->orWhere('lastname', 'like', '%'.$search.'%')
                            ->get()
                            ->mapWithKeys(function ($resident) {
                                return [$resident->id => $resident->full_name]; 
                            });
                    })
                    ->required()
                    ->reactive() 
                    ->afterStateUpdated(function ($state, callable $set) {
                        $resident = Residents::find($state);
                        if ($resident) {
                            $set('resident_name', $resident->full_name);
                            $set('resident_id', $resident->id);
                            $set('email', $resident->resident_email);
                            $set('official_contact_number', $resident->contact_number);
                            $set('address', $resident->address);
                        }
                    })
                    ->columnSpan(3),

                TextInput::make('resident_id')
                    ->label('Resident ID')
                    ->readonly()
                    ->reactive()
                    ->required()
                    ->default(fn () => request()->query('resident_name'))
                    ->afterStateHydrated(function ($state, callable $set) {
                        if ($state) {
                            $resident = Residents::find($state);
                            if ($resident) {
                                $set('resident_name', $resident->full_name);
                                $set('email', $resident->resident_email); 
                                $set('official_contact_number', $resident->contact_number);
                                $set('address', $resident->address);
                            }
                        }
                    }),
                    Select::make('position')
    ->label('Position')
    ->options([
        'Barangay Captain' => 'Barangay Captain',
        'Barangay Councillor' => 'Barangay Councillor',
        'SK Chairperson' => 'SK Chairperson',
        'Barangay Secretary' => 'Barangay Secretary',
        'Barangay Treasurer' => 'Barangay Treasurer',
        'Health Staff' => 'Health Staff',
    ])
    ->required()
    ->columnSpan(2),
                        
                     ])->columns(6),

               
                    TextInput::make('address')
                    ->label('Address')
                    ->required()
                    ->reactive()
                    ->readOnly()
                    ->columnSpan(3),

                TextInput::make('official_contact_number')
                    ->label('Contact Number')
                    ->required()
                    ->reactive()
                    ->readOnly()
                    ->columnSpan(1),
                    TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->readOnly()
                    ->reactive() 
                    ->columnSpan(2),
            
                
                DatePicker::make('term_start')->required()->columnSpan(2),
                DatePicker::make('term_end')->required()->columnSpan(2),

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    
                    ->required()->columnSpan(2),

                ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Official::with('resident'))
            ->columns([
                TextColumn::make('position'),
                TextColumn::make('resident.full_name') 
                    ->label('Complete Name'),

                TextColumn::make('resident.contact_number')->label('Contact Number'),
                TextColumn::make('resident.address')->label('Address'),
                TextColumn::make('status')->badge()->color(function ($record) {
                    { return $record->status === 'active' ? 'primary' : 'warning';}
                }),
            ])->striped()
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficial::route('/'),
            'create' => Pages\CreateOfficial::route('/create'),
            'edit' => Pages\EditOfficial::route('/{record}/edit'),
        ];
    }
}
