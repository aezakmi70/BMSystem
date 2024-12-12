<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\BarangayBudgetResource\Pages;
use App\Models\BarangayBudget;
use Filament\Forms\Components\Section;

class BarangayBudgetResource extends Resource
{
    protected static ?string $model = BarangayBudget::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Barangay Budget';
    protected static ?string $pluralModelLabel = 'Barangay Budgets';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?string $modelLabel = 'Barangay Budget Allocation';
    protected static ?int $navigationSort = 3;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Budget Details')
                    ->schema([
                        TextInput::make('category')
                            ->required()
                            ->label('Category')
                            ->maxLength(100)
                            ->placeholder('Enter budget category'),
                        TextInput::make('allocated_amount')
                            ->required()
                            ->numeric()
                            ->label('Allocated Amount')
                            ->placeholder('Enter the allocated amount')
                            ->step(0.01),
                        TextInput::make('spent_amount')
                            ->required()
                            ->numeric()
                            ->label('Spent Amount')
                            ->placeholder('Enter the spent amount')
                            ->step(0.01),
                        TextInput::make('remaining_amount')
                            ->disabled()
                            ->numeric()
                            ->label('Remaining Amount')
                            ->step(0.01),
                    ])
                    ->columns(2),
                Section::make('Timestamps')
                    ->schema([
                        DatePicker::make('created_at')
                            ->disabled()
                            ->label('Created At')
                            ->default(now()),
                        DatePicker::make('updated_at')
                            ->disabled()
                            ->label('Updated At')
                            ->default(now()),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('category')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('allocated_amount')
                    ->label('Allocated Amount')
                    ->sortable(),
                TextColumn::make('spent_amount')
                    ->label('Spent Amount')
                    ->sortable(),
                TextColumn::make('remaining_amount')
                    ->label('Remaining Amount')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->dateTime(),
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
            'index' => Pages\ListBarangayBudgets::route('/'),
            'create' => Pages\CreateBarangayBudget::route('/create'),
            'edit' => Pages\EditBarangayBudget::route('/{record}/edit'),
        ];
    }
}
