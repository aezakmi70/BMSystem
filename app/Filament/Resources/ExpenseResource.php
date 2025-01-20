<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?string $navigationGroup = 'Financial Management';
    
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('transaction_date')
                            ->required()
                            ->label('Transaction Date')
                            ->placeholder('Select the transaction date'),
                        TextInput::make('category')
                            ->required()
                            ->label('Category')
                            ->maxLength(100)
                            ->placeholder('Enter category'),
                    ])
                    ->columns(2),
                
                Section::make()
                    ->schema([
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->label('Amount')
                            ->placeholder('Enter the amount'),
                        Textarea::make('description')
                            ->required()
                            ->label('Description')
                            ->placeholder('Provide a description'),
                    ])
                    ->columns(2),
                
                Section::make()
                    ->schema([
                        TextInput::make('paid_to')
                            ->required()
                            ->label('Paid To')
                            ->maxLength(100)
                            ->placeholder('Enter the payee or recipient'),
                       Select::make('payment_method')
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
                
                Section::make()
                    ->schema([
                        TextInput::make('receipt_number')
                            ->nullable()
                            ->label('Receipt Number')
                            ->maxLength(50)
                            ->placeholder('Enter receipt number (optional)'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('category')
                    ->sortable()
                    ->label('Category'),
                TextColumn::make('amount')
                    ->money('PHP')
                    ->sortable()
                    ->label('Amount'),
                TextColumn::make('description')
                    ->limit(50)
                    ->label('Description'),
                TextColumn::make('paid_to')
                    ->label('Paid To'),
                TextColumn::make('payment_method')
                    ->label('Payment Method'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
