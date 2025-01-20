<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResidentsResource\Pages;
use App\Models\Residents;


use pxlrbt\FilamentExcel\Columns\Column;
use App\Filament\Exports\ResidentsExporter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Group;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ResidentsResource extends Resource
{
    protected static ?string $model = Residents::class;
    protected static ?string $navigationGroup = 'Barangay'; 
    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';



    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Personal Information')
                ->schema([
                    Section::make('Photo of Resident ')
                    ->schema([
                        FileUpload::make('resident_photo')
                        ->label(' max size of 1536 KB')
                        ->maxWidth(300)
                        ->disk('public') 
                        ->directory('resident_images')        
                        ->maxSize(1536)
                        ->openable()
                        ->panelAspectRatio('1:1')
                        ->required(),
                        ])
                        ->columnSpan(2),
                        
                    Section::make()
                        ->schema([
                            TextInput::make('lastname')->required()->autocapitalize('words'),
                            TextInput::make('firstname')->required()->autocapitalize('words'),
                            TextInput::make('middlename')->nullable()->autocapitalize('words'),
                            Section::make()
                            ->schema([
                                Select::make('gender')
                                    ->options(['male' =>'Male','female' => 'Female'])
                                    ->required(),
    
                                TextInput::make('age')
                                    ->required()
                                    ->reactive(),
                                    
                                DatePicker::make('birthdate')
                                    ->label('Birthdate')
                                    ->required(),
    
                                TextInput::make('bloodtype')->nullable(),
                                ])
                        ->columnSpan(6)
                        ->columns(4),
                        Section::make()
                        ->schema([
                            TextInput::make('birthplace')
                                ->label('Birthplace')
                                ->required()
                                ->autocapitalize('words')
                                ->columnSpan(2),

                            TextInput::make('address')
                                ->label('Address')
                                ->required()
                                ->autocapitalize('words')
                                ->columnSpan(2),

                            Select::make('purok')
                                ->placeholder('Purok #')
                                ->options([
                                    1 => '1',
                                    2 => '2',
                                    3 => '3',
                                    4 => '4',
                                    5 => '5',
                                    6 => '6',
                                    7 => '7',
                                ])
                                
                                ->required()
                                ->columnSpan(1),
                        ])
                        ->columnSpan(5)
                        ->columns(5),
                
                        ])
                        ->columnSpan(4)
                        ->columnStart(3)
                        ->columns(3)
                        ->reactive(),

                   
                           
                Section::make()
                ->schema([TextInput::make('contact_number')->required()->label('Contact Number')->columnSpan(2),
                TextInput::make('resident_email')->required()->label('Email')->columnSpan(2),

                Select::make('differently_abled_person')
                    ->label('Differently Abled Person')
                    ->options(['Yes'=>'Yes','No' => 'No'])
                    ->columnSpan(2)
                    ->nullable(),

                Select::make('marital_status')->label('Civil Status')->required()->columnSpan(2)
                ->options(['Single'=>'Single','Married'=>'Married']),
                TextInput::make('religion')->required()->autocapitalize('words')->columnSpan(2),
                TextInput::make('nationality')->required()->autocapitalize('words')->columnSpan(2),
                TextInput::make('occupation')->nullable()->autocapitalize('words')->columnSpan(2),

                Select::make('monthly_income')
                    ->options([
                        'low_income' => 'Low Income (PHP 10,000 or below)',
                        'lower_middle_income' => 'Lower Middle Income (PHP 10,001 - PHP 20,000)',
                        'middle_income' => 'Middle Income (PHP 20,001 - PHP 50,000)',
                        'upper_middle_income' => 'Upper Middle Income (PHP 50,001 - PHP 100,000)',
                        'high_income' => 'High Income (PHP 100,001 and above)',
                    ])
                    ->columnSpan(2)
                    ->required(),

                TextInput::make('philhealth_no')->required()
                ->columnSpan(2),
               
                Select::make('health_status')
                ->options([
                    'Healthy' => 'Healthy',
                    'Sick' => 'Sick',
                    'Recovered' => 'Recovered',
                ])
                
                ->required()
                ->columnSpan(2),
                    TextArea::make('comment')->columnStart(5)->columnSpan(4),

                                
            ])  ->columnSpan(6)
            ->columns(8),
                    
                   
                       
                        
                        
                   
                       
                ])
                ->columnSpan(2)
                ->columns(6),

                Section::make('Youth Information')
                ->schema([
                    Select::make('youth_classification')
                        ->label('Youth Classification')
                        ->options([
                            'in_school_youth' => 'In school youth',
                            'out_of_school_youth' => 'Out of school youth',
                            'working_youth' => 'Working youth',
                            'youth_with_special_needs' => 'Youth with special needs',
                            'person_with_disability' => 'Person with Disability',
                            'children_in_conflict_with_law' => 'Children in Conflict w/ Law',
                            'indigenous_people' => 'Indigenous People',
                        ])
                        ->columnSpan(2),
            
                    Select::make('youth_age_group')
                        ->label('Youth Age Group')
                        ->options([
                            'child_youth' => 'Child Youth (15-17 yrs. Old)',
                            'core_youth' => 'Core Youth (18-25 yrs. Old)',
                            'young_adult' => 'Young Adult (25-30 yrs. Old)',
                        ])
                        ->columnSpan(2)
                        ->required(),
            
                    Select::make('educational_background')
                        ->label('Educational Background')
                        ->options([
                            'elementary_level' => 'Elementary Level',
                            'elementary_graduate' => 'Elementary Graduate',
                            'high_school_level' => 'High School Level',
                            'high_school_graduate' => 'High School Graduate',
                            'vocational_graduate' => 'Vocational Graduate',
                            'college_level' => 'College Level',
                            'college_graduate' => 'College Graduate',
                            'masters_level' => 'Masters Level',
                            'masters_graduate' => 'Masters Graduate',
                            'doctorate_level' => 'Doctorate Level',
                            'doctorate_graduate' => 'Doctorate Graduate',
                        ])
                        ->columnSpan(2)
                        ->required(),
            
                    Select::make('work_status')
                        ->label('Current Work Status')
                        ->options([
                            'employed' => 'Employed',
                            'unemployed' => 'Unemployed',
                            'self_employed' => 'Self-Employed',
                            'student' => 'Student',
                        ])
                        ->columnSpan(2)
                        ->required(),
            
                    Select::make('is_registered_sk_voter')
                        ->label('Registered SK Voter?')
                        ->placeholder('Select')
                        ->options([
                        'Yes' =>'Yes',
                            'No' => 'No',
                        ])
                        ->columnSpan(2)
                        ->required(),
            
                    Select::make('did_vote_last_sk_election')
                        ->label('Did you vote last SK Election?')
                        ->placeholder('Select')
                        ->options([
                        'Yes' =>'Yes',
                            'No' => 'No',
                        ])
                        ->columnSpan(2)
                        ->nullable(),
            
                    Group::make([])
                        ->columnSpan(6)
                        ->extraAttributes(['style' => 'border-top: 1px solid #ccc; margin: 10px 0; width: 100%;']),
            
                    Select::make('is_registered_national_voter')
                        ->label('Registered National Voter?')
                        ->placeholder('Select')
                        ->options([
                        'Yes' =>'Yes',
                            'No' => 'No',
                        ])
                        ->columnStart(2)
                        ->columnSpan(2)
                        ->required(),
            
                    Select::make('vote_times')
                        ->label('If Yes, How many times?')
                        ->options([
                            '1_2_times' => '1-2 Times',
                            '3_4_times' => '3-4 Times',
                            '5_plus_times' => '5+ Times',
                        ])
                        ->columnSpan(2)
                        ->nullable(),
            
                    Group::make([])
                        ->columnSpan(6)
                        ->extraAttributes(['style' => 'border-top: 1px solid #ccc; margin: 10px 0; width: 100%;']),
            
                    Select::make('has_attended_sk_assembly')
                        ->label('Have you already attended an SK Assembly?')
                        ->options([
                        'Yes' =>'Yes',
                            'No' => 'No',
                        ])
                        ->columnSpan(4)
                        ->required(),
            
                    Select::make('why_no_assembly')
                        ->label('If No, WHY?')
                        ->options([
                            'no_kk_assembly_held' => 'No KK Assembly Held',
                            'not_interested' => 'Not Interested',
                        ])
                        ->nullable()
                        ->columnSpan(2),
                ])
                ->reactive()
                ->columnSpan(2)
                ->columns(6)
                ->hidden(fn ($get) => $get('age') < 15 || $get('age') > 30)
            ]);         
            

              
                
               
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('firstname'),
                TextColumn::make('lastname'),
                TextColumn::make('middlename'),
                TextColumn::make('health_status')
    ->badge()
    ->color(function ($record) {
        { return $record->status === 'Healthy' ? 'warning' : 'primary';}
    }),
      
                TextColumn::make('age')
                ->extraAttributes(['style' => 'border-left: 1px solid #ccc; ']), 
                TextColumn::make('purok')
                ->extraAttributes(['style' => 'border-left: 1px solid #ccc; ']),
                ImageColumn::make('resident_photo')
                ->label('Resident Photo')
                ->extraAttributes(['style' => 'border-left: 1px solid #ccc; ']), 
            ])
            ->striped()
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->withFilename(date('Y-m-d') . ' - export')
                    ->withColumns([
                        Column::make('firstname'),
                        Column::make('middlename'),
                        Column::make('lastname'),
                        Column::make('age'),
                        Column::make('address'),
                        Column::make('contact_number'),
                    ]),
                    
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                
                ->label('Actions'),
            ])
;
    }

    public static function getRelations(): array
    {
        return [
           ResidentsResource\RelationManagers\HealthProfileRelationManager::class,
           ResidentsResource\RelationManagers\HealthServicesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResidents::route('/'),
            'create' => Pages\CreateResidents::route('/create'),
            'edit' => Pages\EditResidents::route('/{record}/edit'),
        ];
    }
}
