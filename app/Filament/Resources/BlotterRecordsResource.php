<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlotterRecordsResource\Pages;
use App\Filament\Resources\BlotterRecordsResource\RelationManagers;
use App\Models\BlotterRecords;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\select;

class BlotterRecordsResource extends Resource
{
    protected static ?string $model = BlotterRecords::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               

                DatePicker::make('dateRecorded')
                    ->label('Date Recorded')
                    ->required(),

                TextInput::make('complainant')
                    ->label('Complainant')
                    ->required(),

                TextInput::make('cage')
                    ->label('Complainant’s Age')
                    ->numeric()
                    ->required(),

                TextInput::make('caddress')
                    ->label('Complainant’s Address')
                    ->required(),

                TextInput::make('ccontact')
                    ->label('Complainant’s Contact')
                    ->tel()
                    ->maxLength(15)
                    ->required(),

                TextInput::make('personToComplain')
                    ->label('Person to Complain')
                    ->required(),

                TextInput::make('page')
                    ->label('Person’s Age')
                    ->numeric()
                    ->required(),

                TextInput::make('paddress')
                    ->label('Person’s Address')
                    ->required(),

                TextInput::make('pcontact')
                    ->label('Person’s Contact')
                    ->tel()
                    ->maxLength(15)
                    ->required(),

                TextInput::make('complaint')
                    ->label('Complaint Details')
                    ->required(),

                TextInput::make('actionTaken')
                    ->label('Action Taken')
                    ->maxLength(50)
                    ->required(),

                Select::make('sStatus')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->required(),

                TextInput::make('locationOfIncidence')
                    ->label('Location of Incidence')
                    
                    ->required(),

                TextInput::make('recordedby')
                    ->label('Recorded By')
                    ->maxLength(50)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('complainant'),
                TextColumn::make('dateRecorded'),
                TextColumn::make('sStatus')->label('Status'),
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
            'index' => Pages\ListBlotterRecords::route('/'),
            'create' => Pages\CreateBlotterRecords::route('/create'),
            'edit' => Pages\EditBlotterRecords::route('/{record}/edit'),
        ];
    }
}
