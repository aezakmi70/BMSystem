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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sPosition')->required(),
            TextInput::make('completeName')->required(),
            TextInput::make('email')->email()->required(),
            TextInput::make('pcontact')->required(),
            TextInput::make('paddress')->required(),
            DatePicker::make('termStart')->required(),
            DatePicker::make('termEnd')->required(),
            TextInput::make('status')->required(),
            TextInput::make('password')->password()->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('sPosition')->sortable(),
            TextColumn::make('completeName')->sortable(),
            TextColumn::make('email'),
            TextColumn::make('pcontact'),
            TextColumn::make('termStart')->date(),
            TextColumn::make('termEnd')->date(),
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
