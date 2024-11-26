<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficialResource\Pages;
use App\Filament\Resources\OfficialResource\RelationManagers;
use App\Models\Official;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('position')
                ->options([
                    'captain' => 'Captain',
                    'councilor' => 'Councilor',
                ])
                ->required(),
                Select::make('completeName') // Save the resident's ID in the official's model
                    ->label('Complete Name')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\Residents::query()
                            ->where('firstname', 'like', '%'.$search.'%')
                            ->orWhere('middlename', 'like', '%'.$search.'%')
                            ->orWhere('lastname', 'like', '%'.$search.'%')
                            ->get()
                            ->mapWithKeys(function ($resident) {
                                // Concatenate first, middle, and last names for display and storage
                                return [$resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname => $resident->firstname . ' ' . $resident->middlename . ' ' . $resident->lastname];
                            });
                    })
                    ->required(),
            
            TextInput::make('email')->email()->required(),
            TextInput::make('contactNumber')
            ->label('Contact Number')
            ->required(),
            TextInput::make('address')->required(),
            DatePicker::make('termStart')->required(),
            DatePicker::make('termEnd')->required(),
            Select::make('status')
            ->options([
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            ])
            ->required(),
            TextInput::make('password')->password()->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Official::with('resident'))
           
            ->columns([
            TextColumn::make('position')->sortable(),
            TextColumn::make('completeName') // Assuming you have a `completeName` accessor on the `Official` model
                    ->label('Complete Name')
                    ->sortable()
                    ->searchable(),
            TextColumn::make('email'),
            TextColumn::make('contactNumber'),
            
            TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficial::route('/'),
            'create' => Pages\CreateOfficial::route('/create'),
            'edit' => Pages\EditOfficial::route('/{record}/edit'),
        ];
    }
}
