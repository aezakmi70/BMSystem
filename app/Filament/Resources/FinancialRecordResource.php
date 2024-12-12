<?php

namespace App\Filament\Resources;

use App\Models\CertificateRequest;
use App\Models\Expense;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\FinancialRecordResource\Pages;
use App\Models\FinancialRecords;
use App\Filament\Exports\ExpenseExporter;
use App\Filament\Exports\CertificateRequestExporter;
use Filament\Tables\Actions\ExportAction;

class FinancialRecordResource extends Resource
{
    protected static ?string $model = FinancialRecords::class;
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function table(Tables\Table $table): Tables\Table
    {
        $currentView = session()->get('financial_view', 'expenses');
        $incomeColumns = self::getIncomeColumns();
        $expenseColumns = self::getExpenseColumns();
        $incomeQuery = CertificateRequest::query()->where('status', 'issued');
        $expenseQuery = Expense::query();

        return $table
            ->headerActions([
                ExportAction::make()
                ->exporter($currentView === 'income' ? CertificateRequestExporter::class : ExpenseExporter::class),
                Action::make('toggle')
                    ->label('Switch View')
                    ->action(function () use ($currentView) {
                        $newView = $currentView === 'income' ? 'expenses' : 'income';
                        session()->put('financial_view', $newView);
                        return redirect()->route('filament.admin.resources.financial-records.index');
                    })
                    ->icon(fn () => $currentView === 'income' ? 'heroicon-o-minus' : 'heroicon-o-plus')
                    ->button()
                    ->color('primary')
                    ->tooltip('Toggle between Income and Expenses'),
            ])
            ->columns($currentView === 'income' ? $incomeColumns : $expenseColumns)  
            ->query($currentView === 'income' ? $incomeQuery : $expenseQuery); 
    }


    public static function getIncomeColumns(): array
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


    public static function getExpenseColumns(): array
    {
        return [
            TextColumn::make('transaction_date')->label('Transaction Date'),
            TextColumn::make('category')->label('Category'),
            TextColumn::make('amount')->label('Amount'),
            TextColumn::make('description')->label('Description'),
            TextColumn::make('paid_to')->label('Paid To'),
            TextColumn::make('payment_method')->label('Payment Method'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialRecords::route('/'),
        ];
    }
}
