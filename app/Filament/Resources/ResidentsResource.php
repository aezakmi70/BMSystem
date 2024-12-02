<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResidentsResource\Pages;
use App\Filament\Resources\ResidentsResource\RelationManagers;
use App\Models\Residents;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class ResidentsResource extends Resource
{
    protected static ?string $model = Residents::class;
    protected static ?string $navigationGroup = 'Barangay'; // Group the tab belongs to
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('lastname')->required(),
                TextInput::make('firstname')->required(),
                TextInput::make('middlename')->nullable(),
                TextInput::make('birthdate')->required(),
                TextInput::make('birthplace')->required(),
                TextInput::make('age')->required(),
                TextInput::make('contactNumber')->required(),
                TextInput::make('barangay')->required(),
                Select::make('purok')
                ->options([
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                ])
                ->required(),
                TextInput::make('differently_abled_person')->nullable(),
                TextInput::make('marital_status')->required(),
                TextInput::make('bloodtype')->nullable(),
                TextInput::make('occupation')->nullable(),
                select::make('monthly_income')
                ->options([
                    'low_income' => 'Low Income (PHP 10,000 or below)', 
                    'lower_middle_income' => 'Lower Middle Income (PHP 10,001 - PHP 20,000)', 
                    'middle_income' => 'Middle Income (PHP 20,001 - PHP 50,000)', 
                    'upper_middle_income' => 'Upper Middle Income (PHP 50,001 - PHP 100,000)', 
                    'high_income' => 'High Income (PHP 100,001 and above)', 
                ])
                ->required(),
                TextInput::make( 'religion')->required(),
                TextInput::make('nationality')->required(),
                Select::make('gender')
                ->options([
                    'male' => 'Male',   
                    'female' => 'Female',
                ])
                ->required(),
                TextInput::make('philhealth_No')->required(),

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
                TextColumn::make('age'),
                TextColumn::make('purok'),
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
            'index' => Pages\ListResidents::route('/'),
            'create' => Pages\CreateResidents::route('/create'),
            'edit' => Pages\EditResidents::route('/{record}/edit'),
        ];
    }
}
