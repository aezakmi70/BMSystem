<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlotterRecordsResource\Pages;
use App\Models\BlotterRecords;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Residents;
use App\Models\Official;
use DateTime;
use Filament\Forms\Components\Section;

class BlotterRecordsResource extends Resource
{
    protected static ?string $model = BlotterRecords::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Barangay';
    protected static ?int $navigationSort = 1;
    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Person to Complain Information')
                    ->schema([
                        Checkbox::make('person_to_complain_is_non_resident')
                            ->label('Person is not from the area')
                            ->reactive(),
                        Section::make()
                            ->schema([
                                Select::make('person_to_complain_name')
                                    ->label('Person to Complain (Full Name)')
                                    ->columnSpan(3)
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
                                    ->hidden(fn (callable $get) => $get('person_to_complain_is_non_resident'))
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $resident = Residents::find($state);
                                        if ($resident) {
                                            $set('person_to_complain_id', $resident->id);
                                            $set('person_to_complain_address', $resident->address);
                                            $set('person_to_complain_age', (new DateTime($resident->birthdate))->diff(new DateTime())->y);
                                            $set('person_to_complain_name', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                                        }
                                    }),
                                TextInput::make('person_to_complain_id')
                                    ->label('Resident ID')
                                    ->readOnly()
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => $get('person_to_complain_is_non_resident')),
                                TextInput::make('person_to_complain_age')
                                    ->label('Age')
                                    ->readOnly()
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => $get('person_to_complain_is_non_resident')),
                                TextInput::make('person_to_complain_name')
                                    ->label('Full Name')
                                    ->columnSpan(4)
                                    ->required(fn (callable $get) => $get('person_to_complain_is_non_resident'))
                                    ->hidden(fn (callable $get) => !$get('person_to_complain_is_non_resident')),
                                TextInput::make('person_to_complain_age')
                                    ->label('Age')
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => !$get('person_to_complain_is_non_resident'))
                            ])->columns(5),
                        TextInput::make('person_to_complain_address')
                            ->label('Address')
                            ->readOnly()
                            ->hidden(fn (callable $get) => $get('person_to_complain_is_non_resident')),
                        TextInput::make('person_to_complain_address')
                            ->label('Address')
                            ->required(fn (callable $get) => $get('person_to_complain_is_non_resident'))
                            ->hidden(fn (callable $get) => !$get('person_to_complain_is_non_resident')),
                    ])
                    ->reactive()
                    ->label('Person to Complain Information')
                    ->columnSpan(1),

                    //complainant
                Section::make('Complainant Information')
                    ->schema([
                        Checkbox::make('complainant_is_non_resident')
                            ->label('Person is not from the area')
                            ->reactive(),
                        Section::make()
                            ->schema([
                                Select::make('complainant_name')
                                    ->label('Complainant (Resident Full Name)')
                                    ->searchable()
                                    ->columnSpan(3)
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
                                    ->hidden(fn (callable $get) => $get('complainant_is_non_resident'))
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $resident = Residents::find($state);
                                        if ($resident) {
                                            $set('complainant_id', $resident->id);
                                            $set('complainant_address', $resident->address);
                                            $set('complainant_age', (new DateTime($resident->birthdate))->diff(new DateTime())->y);
                                            $set('complainant_name', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                                        }
                                    }),
                                TextInput::make('complainant_id')
                                    ->label('Resident ID')
                                    ->readOnly()
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => $get('complainant_is_non_resident')),
                                TextInput::make('complainant_age')
                                    ->label('Age')
                                    ->readOnly()
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => $get('complainant_is_non_resident')),
                                    TextInput::make('complainant_name')
                                    ->label('Full Name')
                                    ->columnSpan(4)
                                    ->required(fn (callable $get) => $get('complainant_is_non_resident'))
                                    ->hidden(fn (callable $get) => !$get('complainant_is_non_resident')),
                                    TextInput::make('complainant_age')
                                    ->label('Age')
                                    ->columnSpan(1)
                                    ->hidden(fn (callable $get) => !$get('complainant_is_non_resident')),
                                
                                
                            ])->columns(5),
                        TextInput::make('complainant_address')
                            ->label('Address')
                            ->readOnly()
                            ->hidden(fn (callable $get) => $get('complainant_is_non_resident')),
                        TextInput::make('complainant_address')
                            ->label('Address')
                            ->required(fn (callable $get) => $get('complainant_is_non_resident'))
                            ->hidden(fn (callable $get) => !$get('complainant_is_non_resident')),
                    ])
                    ->label('Complainant Information')
                    ->columnSpan(1),
                    Section::make()
                    ->schema([
                Section::make()
                    ->schema([
                        Select::make('respondent_id')
                            ->label('Respondent Name')
                            ->searchable()
                            ->columnSpan(3)
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
                                $respondent = Residents::find($state);
                                if ($respondent) {
                                    $set('respondent_id', $respondent->id);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set) {
                                if ($state) {
                                    $resident = Residents::find($state);
                                    if ($resident) {
                                        $set('respondent_id', $resident->full_name);
                                    }
                                }
                            }),
                            Select::make('status')
                            ->options([
                            'Pending' => 'Pending',
                        'Under Investigation' => 'Under Investigation',
                 'Resolved' => 'Resolved',
                            'Unresolved' => 'Unresolved',
                 'Escalated' => 'Escalated',
              'Dismissed' => 'Dismissed',
           'For Mediation' => 'For Mediation',
                      'For Hearing' => 'For Hearing',
                 'Closed' => 'Closed',
                 'Cancelled' => 'Cancelled',
                ])
                    ->default('Pending')
                    ->columnSpan(2)
                         ->required(),
                        DatePicker::make('incident_date')
                        ->default(now())
                        ->label('Incident Date')
                        ->columnSpan(5)
                        ->required(),
                        Select::make('recorded_by')
                            ->label('Recorded By')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                return Official::query()
                                    ->where('complete_name', 'like', '%' . $search . '%')
                                    ->get()
                                    ->mapWithKeys(function ($official) {
                                        return [$official->id => $official->complete_name . ' - ' . $official->position];
                                    });
                            })
                            ->required()
                            ->columnSpan(5)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $official = Official::find($state);
                                if ($official) {
                                    $set('recorded_by', $official->id);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set) {
                                if ($state) {
                                    $resident = Official::find($state);
                                    if ($resident) {
                                        $set('recorded_by', $resident->full_name);
                                    }
                                }
                            }),
                    ])
                    ->label('Respondent Information')
                    ->columns(5)
                    ->columnSpan(1),
                Section::make()
                    ->schema([
                        
                        TextInput::make('incident_location')->label('Location')->required()->default('Balindog, Kidapawan City'),
                        Textarea::make('incident_details')->label('Details')->required(),
                    ])
                    ->label('Incident Details')
                    ->columnSpan(1),
                    ])
                    ->columnSpan(2)
                    ->columns(2),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('complainant_name')->label('Complainant Name'),
                TextColumn::make('person_to_complain_name')->label('Person to Complain'),
                TextColumn::make('incident_location')->label('Incident Location'),
                TextColumn::make('incident_date')->label('Date of Incident'),
                TextColumn::make('status')->label('Status')
                ->badge()
                ->color(function ($record) 
                { return $record->status === 'resolved' ? 'primary' : 'warning'; }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlotterRecords::route('/'),
            'create' => Pages\CreateBlotterRecords::route('/create'),
            'edit' => Pages\EditBlotterRecords::route('/{record}/edit'),
        ];
    }
}
