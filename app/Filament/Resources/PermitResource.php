<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermitResource\Pages;
use App\Models\Permit;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class PermitResource extends Resource
{
    protected static ?string $model = Permit::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('residentid')
                    ->label('Resident ID')
                    ->numeric()
                    ->required(),
                Textarea::make('businessName')
                    ->label('Business Name')
                    ->required(),
                Textarea::make('businessAddress')
                    ->label('Business Address')
                    ->required(),
                TextInput::make('typeOfBusiness')
                    ->label('Type of Business')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('orNo')
                    ->label('OR Number')
                    ->numeric()
                    ->required(),
                TextInput::make('samount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
                DatePicker::make('dateRecorded')
                    ->label('Date Recorded')
                    ->required(),
                TextInput::make('recordedBy')
                    ->label('Recorded By')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('status')
                    ->label('Status')
                    ->maxLength(20)
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('residentid')
                    ->label('Resident ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('businessName')
                    ->label('Business Name')
                    ->limit(50)
                    ->searchable(),
               
                TextColumn::make('typeOfBusiness')
                    ->label('Type of Business')
                    ->sortable()
                    ->searchable(),
               
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
            ])
            ->filters([
                // Add filters here if needed
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
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermits::route('/'),
            'create' => Pages\CreatePermit::route('/create'),
            'edit' => Pages\EditPermit::route('/{record}/edit'),
        ];
    }
}
