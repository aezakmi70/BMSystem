<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateRequestResource\Pages;
use App\Models\CertificateRequest;
use Dompdf\FrameDecorator\Inline;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Forms\Components\Text;
use DateTime;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to

    // Define price for each purpose
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
            Forms\Components\Section::make('Additional Resident Info')
            ->schema([
            TextInput::make('residentid')
                ->label('Resident ID')
                ->readonly(),
                
              
    
            TextInput::make('residentAge')
                ->label('Resident Age')
                ->readonly(),
              

            TextInput::make('residentBirthdate')
                ->label('Resident Birthdate')
                ->readonly(),
                

            ])
            ->columns(3),


            Forms\Components\Section::make()
            ->schema([
             // Resident Name and ID
             Select::make('residentName')
             ->label('Resident Full Name')
             ->searchable()
             ->getSearchResultsUsing(function (string $search) {
                 return \App\Models\Residents::query()
                     ->where('firstname', 'like', '%'.$search.'%')
                     ->orWhere('middlename', 'like', '%'.$search.'%')
                     ->orWhere('lastname', 'like', '%'.$search.'%')
                     ->get()
                     ->mapWithKeys(function ($resident) {
                         return [$resident->id => $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname];
                     });
             })
             ->required()
             ->afterStateUpdated(function ($state, callable $set) {
                 $resident = \App\Models\Residents::find($state);
                 if ($resident) {
                     $set('residentid', $resident->id);
                     $set('residentBirthdate', $resident->birthdate);
                     $set('residentAge', (new DateTime($resident->birthdate))->diff(new DateTime())->y);
                     $set('residentName', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                 }
             }),
             //Certificate to Issue
            Select::make('certificateToIssue')
                ->label('Certificate to Issue')
                ->required()
                ->options(self::$certificates)
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $index = (int) $state;
                    //Index for setting amount
                    if (isset(self::$prices[$index])) {
                        $set('samount', self::$prices[$index]);
                    } 
                    if ($state == 4) {  // Business Clearance selected
                        $set('businessName', ''); 
                        $set('businessAddress', ''); 
                        $set('typeOfBusiness', '');
                    } else {
                        $set('businessName', null);
                        $set('businessAddress', null);
                        $set('typeOfBusiness', null);
                    }
                }),

           
            // Purpose and other common fields
            Textarea::make('purpose')
                ->label('Purpose')
                ->required(),

            // Amount based on purpose
            TextInput::make('orNo')
                ->label('OR No')
                ->required()
                ->numeric(),

            TextInput::make('samount')
                ->label('Amount')
                ->required()
                ->numeric()
                ->readonly(),

            DatePicker::make('dateRecorded')
                ->label('Date Recorded')
                ->required(),

            TextInput::make('recordedBy')
                ->label('Recorded By')
                ->required(),

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

            // Additional fields for Business Clearance purpose
            TextInput::make('businessName')
                ->label('Business Name')
                ->required()
                ->hidden(fn ($get) => $get('certificateToIssue') != 4), // Only show if Business Clearance is selected

            Textarea::make('businessAddress')
                ->label('Business Address')
                ->required()
                ->hidden(fn ($get) => $get('certificateToIssue') != 4), // Only show if Business Clearance is selected
                
            Textarea::make('typeOfBusiness')
                ->label('Business Type')
                ->required()
                ->hidden(fn ($get) => $get('certificateToIssue') != 4), // Only show if Business Clearance is selected
                ])
                ->columnSpan(2) 
                ->columns(3)
                ->reactive(),

                

        ]);
}

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(CertificateRequest::with('resident'))
            ->columns([
                TextColumn::make('resident_name')
                    ->label('Resident Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('certificateToIssue')
                    ->label('Certificate Issued')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return self::$certificates[$state] ?? 'Unknown';
                    }),

                TextColumn::make('samount')
                    ->label('Amount')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('dateRecorded')
                    ->label('Date Recorded')
                    ->date(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
            ]); 
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
