<?php

namespace App\Filament\Resources;

use App\Models\Income;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Resources\IncomeResource\Pages;
use App\Models\CertificateRequest;
use App\Models\Residents;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use App\Filament\Exports\IncomeExporter;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-circle';
    protected static ?string $navigationLabel = 'Income';
    protected static ?string $navigationGroup = 'Financial Management';

    public static function table(Table $table): Table
    {

        $currentView = session()->get('incomes_view', 'income');

        $incomeColumns = self::getIncomeColumns();
        $certificateRequestColumns = self::getCertificateRequestColumns();

        $incomeQuery = Income::query();
        $certificateRequestQuery = CertificateRequest::query()->where('status', 'issued');

        return $table
            ->headerActions([

                
                    ExportAction::make()->exports([
                        ExcelExport::make()->withFilename(date('Y-m-d') . ' - export')
                        ->withColumns([
                            Column::make('payer'),
                            Column::make('description'),
                            Column::make('payment_method'),
                            Column::make('recorded_by'),
                            Column::make('transaction_date'),
                        ]),
                        
                    ]),
               
                Action::make('toggle')
                    ->label(fn () => $currentView === 'income' ? 'Switch to Certificate Requests' : 'Switch to Income')
                    ->action(function () use ($currentView) {
                        $newView = $currentView === 'income' ? 'certificate_request' : 'income';
                        session()->put('incomes_view', $newView);
                        return redirect()->route('filament.admin.resources.incomes.index');
                    })
                    ->icon(fn () => $currentView === 'income' ? 'heroicon-o-minus' : 'heroicon-o-plus')
                    ->button()
                    ->color('primary')
                    ->tooltip('Toggle between Income and Certificate Requests'),
            ])
            ->columns($currentView === 'income' ? $incomeColumns : $certificateRequestColumns)
            ->query($currentView === 'income' ? $incomeQuery : $certificateRequestQuery);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Transaction Details')
                    ->schema([
                        TextInput::make('payer')
                            ->label('Payer')
                            ->required(),
                        TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric(),
                     
                    ])
                    ->columns(2),
                
                Section::make('Description')
                    ->schema([
                        TextArea::make('description')
                            ->label('Description')
                            ->maxLength(255)
                            ->required(),
                            Forms\Components\Select::make('payment_method')
                            ->required()
                            ->label('Payment Method')
                            ->options([
                                'Cash' => 'Cash',
                                'Bank Transfer' => 'Bank Transfer',
                                'Cheque' => 'Cheque',
                                'GCash' => 'GCash',
                                'Other' => 'Other',
                            ])
                            ->placeholder('Select payment method'),
                    ])
                    ->columns(2),

                Section::make('Recorded By')
                    ->schema([
                        Select::make('recorded_by')
                            ->label('Recorded By')
                            ->searchable()
                            ->required()
                            ->getSearchResultsUsing(function (string $search) {
                                return Residents::query()
                                    ->from('resident_tbl as r')
                                    ->join('official_tbl as o', 'r.id', '=', 'o.resident_id')
                                    ->where('r.firstname', 'like', '%' . $search . '%')
                                    ->select('r.id', 'r.firstname', 'r.middlename', 'r.lastname', 'o.position')
                                    ->get()
                                    ->mapWithKeys(function ($resident) {
                                        return [$resident->id => $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname . ' - ' . $resident->position];
                                    });
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $resident = Residents::query()
                                    ->from('resident_tbl as r')
                                    ->join('official_tbl as o', 'r.id', '=', 'o.resident_id')
                                    ->where('r.id', $state)
                                    ->select('r.id', 'r.firstname', 'r.middlename', 'r.lastname', 'o.position')
                                    ->first();

                                if ($resident) {
                                    $full_name = $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname;
                                    $set('recorded_by', $full_name);
                                    $set('position', $resident->position);
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set) {
                                if ($state) {
                                    $resident = Residents::query()
                                        ->from('resident_tbl as r')
                                        ->join('official_tbl as o', 'r.id', '=', 'o.resident_id')
                                        ->where('r.id', $state)
                                        ->select('r.id', 'r.firstname', 'r.middlename', 'r.lastname', 'o.position')
                                        ->first();

                                    if ($resident) {
                                        $full_name = $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname;
                                        $set('recorded_by', $full_name);
                                        $set('position', $resident->position);
                                    }
                                }
                            }),
                            DatePicker::make('transaction_date')
                            ->label('Transaction Date')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getCertificateRequestColumns(): array
    {
        return [
            TextColumn::make('resident_name')
                ->label('Resident Name'),
            TextColumn::make('purpose')
                ->label('Purpose'),
            TextColumn::make('samount')
                ->label('Amount')
                ->formatStateUsing(fn ($state) => number_format($state, 2)),
            TextColumn::make('date_recorded')
                ->label('Date Recorded')
                ->date(),
            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->colors([
                    'success' => 'issued',
                    'warning' => 'pending',
                ]),
        ];
    }

    public static function getIncomeColumns(): array
    {
        return [
            TextColumn::make('payer')->label('Payer'),
            TextColumn::make('amount')->label('Amount')->money('PHP'),
            TextColumn::make('payment_method')->label('Payment Method'),
            TextColumn::make('transaction_date')->label('Transaction Date')->date(),
            TextColumn::make('description')->label('Description')->limit(50),
            
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
