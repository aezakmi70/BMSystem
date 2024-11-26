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
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to

    // Define price for each purpose
    protected static $purposes = [
        0 => 'Certificate of Indigency',
        1 => 'BRGY. Certificate',
        2 => 'Certificate Residency',
        3 => 'Business Clearance',
        4 => 'Cedula',
    ];

    protected static $prices = [
        0 => 100,  // Certificate of Indigency
        1 => 50,   // BRGY. Certificate
        2 => 75,   // Certificate Residency
        3 => 150,  // Business Clearance
        4 => 30,   // Cedula
    ];

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('purpose')
                    ->label('Purpose')
                    ->required()
                    ->options(self::$purposes)
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Dynamically show fields based on the selected purpose
                        $index = (int) $state;  // Cast state to an integer to match the array index

                        // Check if index exists in the prices array and set the amount
                        if (isset(self::$prices[$index])) {
                            $set('samount', self::$prices[$index]);
                        } 
                        if ($state == 3) {  // Business Clearance selected
                            // Add fields specific to Business Clearance
                            $set('businessName', ''); // Add Business Name field (for example)
                            $set('businessAddress', ''); // Add Business Address field (for example)
                        } else {
                            // Clear or hide fields related to Business Clearance
                            $set('businessName', null);
                            $set('businessAddress', null);
                        }
                    }),

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
                            $set('residentName', $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname);
                        }
                    }),

                TextInput::make('residentid')
                    ->label('Resident ID')
                    ->readOnly()
                    ->required(),

                // Findings and other common fields
                Textarea::make('findings')
                    ->label('Findings')
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
                    ->required(),

                // Additional fields for Business Clearance purpose
                TextInput::make('businessName')
                    ->label('Business Name')
                    ->required()
                    ->hidden(fn ($get) => $get('purpose') != 3), // Only show if Business Clearance is selected

                Textarea::make('businessAddress')
                    ->label('Business Address')
                    ->required()
                    ->hidden(fn ($get) => $get('purpose') != 3), // Only show if Business Clearance is selected
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

                TextColumn::make('purpose')
                    ->label('Purpose')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return self::$purposes[$state] ?? 'Unknown';
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
