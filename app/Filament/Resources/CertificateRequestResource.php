<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateRequestResource\Pages;
use App\Models\CertificateRequest;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use App\Models\Official;
use App\Models\Residents;
use DateTime;
use Filament\Forms\Components\Section;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to
    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', '=', 'pending')->count();
    }

    protected static $certificates = [
        0 => 'Certificate of Indigency',
        1 => 'BRGY. Clearance',
        2 => 'Certificate of Residency',
        3 => 'Certificate of Low Income',
        4 => 'Business Clearance',
        5 => 'Business Permit',
        6 => 'Cedula',
        7 => 'Cutting Permit',
    ];

    protected static $prices = [
        0 => 20,   //'Certificate of Indigency',
        1 => 100,  // 'BRGY. Clearance',
        2 => 50,   // 'Certificate of Residency',
        3 => 75,   // 'Certificate of Low Income',
        4 => 150,  // 'Business Clearance',
        5 => 30,   // 'Business Permit',
        6 => 100,  // 'Cedula',
        7 => 50,   //'Cutting',
    ];
    
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                Section::make()
                    ->schema([
                        Select::make('resident_name')
                            ->label('Resident FullName')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return Residents::query()
                                    ->where('firstname', 'like', '%' . $search . '%')
                                    ->orWhere('middlename', 'like', '%' . $search . '%')
                                    ->orWhere('lastname', 'like', '%' . $search . '%')
                                    ->get()
                                    ->mapWithKeys(function ($resident) {
                                        return [$resident->id => $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname];
                                    });
                            })
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $resident = Residents::find($state);
                                if ($resident) {
                                    $set('residentid', $resident->id);
                                    $set('resident_birthdate', $resident->birthdate);
                                    $set('resident_age', (new DateTime($resident->birthdate))->diff(new DateTime())->y);
                                    $set('resident_name', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                                }
                            }),

                        Select::make('certificate_to_issue')
                            ->label('Certificate to Issue')
                            ->required()
                            ->options(self::$certificates)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $index = (int)$state;
                                if (isset(self::$prices[$index])) {
                                    $set('samount', self::$prices[$index]);
                                }
                                if ($state == 4 || $state == 5) { 
                                    $set('business_name', '');
                                    $set('business_address', '');
                                    $set('type_of_business', '');
                                } else {
                                    $set('business_name', null);
                                    $set('business_address', null);
                                    $set('type_of_business', null);
                                }
                            }),

                        TextInput::make('or_no')
                            ->label('OR No')
                            ->required()
                            ->numeric(),

                        TextInput::make('business_name')
                            ->label('Business Name')
                            ->required()
                            ->hidden(fn ($get) => !in_array($get('certificate_to_issue'), [4, 5])), 

                        TextInput::make('business_address')
                            ->label('Business Address')
                            ->required()
                            ->hidden(fn ($get) => !in_array($get('certificate_to_issue'), [4, 5])), 

                        TextInput::make('type_of_business')
                            ->label('Business Type')
                            ->required()
                            ->hidden(fn ($get) => !in_array($get('certificate_to_issue'), [4, 5])),
                            Textarea::make('purpose')
                            ->label('Purpose')
                            ->required()
                            
                    ])
                    ->columnSpan(2)
                    ->columns(3)
                    ->reactive(),
//

Section::make('Additional Resident Info')
    ->schema([
        TextInput::make('residentid')
            ->label('Resident ID')
            ->readonly(),
           
        TextInput::make('resident_age')
            ->label('Resident Age')
            ->readonly(),
           

        TextInput::make('resident_birthdate')
            ->label('Resident Birthdate')
            ->readonly(),
            
    ])
    ->hidden(fn ($get) => !$get('resident_name'))
    ->columns(3),


    //
                Section::make()
                    ->schema([
                        TextInput::make('samount')
                            ->label('Amount')
                            ->required()
                            ->numeric()
                            ->readonly(),
                            Select::make('recorded_by')
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
                                    $set('recorded_b', $resident->full_name);
                                }
                              
                            })
                            ->afterStateHydrated(function ($state, callable $set){
                                $resident = Residents::find($state);
                                $official = Official::where('resident_id', $state)->first();
                                if ($official) {
                                    $set('recorded_by', $resident->full_name);

                                }
                               
                            }),
                        
                            Select::make('present_official')
                            ->label('Officer Of The Day')
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
                                if ($resident) {
                                    $set('official_position', $official->position);
                                    $set('present_official', $resident->full_name);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set){
                                $resident = Residents::find($state);
                                $official = Official::where('resident_id', $state)->first();
                                if ($resident) {
                                    $set('present_official', $resident->full_name);
                                    $set('official_position', $official->position);
                                }
                               
                            }),
                        
                      
                        
                            
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'issued' => 'Issued',
                                'cancelled' => 'Cancelled',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending'),
                            
                            DatePicker::make('date_recorded')
                            ->label('Date Recorded')
                            ->required()
                            ->default(now()), // Set default value to the current date
                        
                         
                            TextInput::make('official_position')
                            ->label('Position')
                            ->required()
                            ->readonly(),
                            
                    ])
                            ->columnSpan(2)
                            ->columns(3)
                            ->reactive(),
                    
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            
            ->columns([
                TextColumn::make('resident_name')
                    ->label('Resident Name')
                    ->sortable(),
                    

                TextColumn::make('certificate_to_issue')
                    ->label('Certificate Issued')
                    ->formatStateUsing(function ($state) {
                        return self::$certificates[$state] ?? 'Unknown';
                    }),

                TextColumn::make('samount')
                    ->label('Amount')
                    ->money('PHP'),

                TextColumn::make('date_recorded')
                    ->label('Date Recorded')
                    ->date(),

                    TextColumn::make('present_official')
                    ->label('Attending Official'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(function ($record) {
                        { return $record->status === 'issued' ? 'primary' : 'warning';}
                    })
                    ->icon(function ($record) {
                        return match ($record->status) {
                            'issued' => 'heroicon-o-check-circle',
                            'pending' => 'heroicon-o-ellipsis-horizontal-circle',     
                            'rejected' => 'heroicon-o-x-circle', 
 
                        };
                        
                    })  
                    
                       
                   
                   
                    
                    ])->striped();
                    
            
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificateRequests::route('/'),
            'create' => Pages\CreateCertificateRequest::route('/create'),
            'edit' => Pages\EditCertificateRequest::route('/{record}/edit'),
        ];
    }
}
