<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Income;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;


class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes'; // Icon for the tab
    protected static ?string $navigationLabel = 'Income'; // Tab name in Filament
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to
    protected static ?int $navigationSort = 2; // Position of the tab in the navigation
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // You can leave this empty or add fields for further filtering if required
            ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Income::with('resident'))
            ->columns([
                TextColumn::make('residentName')
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
            'index' => Pages\ListIncomes::route('/'),
            // You can leave the 'create' and 'edit' routes out if you don't need them for this page
        ];
    }
}
