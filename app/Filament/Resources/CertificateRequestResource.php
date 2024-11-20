<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateRequestResource\Pages;
use App\Models\CertificateRequest;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('clearanceNo')
                    ->label('Clearance No')
                    ->required()
                    ->numeric(),
                TextInput::make('residentid')
                    ->label('Resident ID')
                    ->required()
                    ->numeric(),
                Textarea::make('findings')
                    ->label('Findings')
                    ->required(),
                Textarea::make('purpose')
                    ->label('Purpose')
                    ->required(),
                TextInput::make('orNo')
                    ->label('OR No')
                    ->required()
                    ->numeric(),
                TextInput::make('samount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('dateRecorded')
                    ->label('Date Recorded')
                    ->required(),
                TextInput::make('recordedBy')
                    ->label('Recorded By')
                    ->required(),
                TextInput::make('status')
                    ->label('Status')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('clearanceNo')
                    ->label('Clearance No')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('residentid')
                    ->label('Resident ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('purpose')
                    ->label('Purpose')
                    ->limit(50)
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
                // Add custom filters if needed
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
            'index' => Pages\ListCertificateRequests::route('/'),
            'create' => Pages\CreateCertificateRequest::route('/create'),
            'edit' => Pages\EditCertificateRequest::route('/{record}/edit'),
        ];
    }
}
