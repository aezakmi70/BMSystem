<?php

namespace App\Filament\Resources;

use App\Models\AuditLog;
use Filament\Resources\Resource;

use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Filament\Resources\AuditLogResource\Pages;
use Filament\Tables\Columns\TextColumn;
class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass'; // Choose an appropriate icon
    protected static ?string $navigationLabel = 'Audit Logs';
    protected static ?string $pluralModelLabel = 'Audit Logs';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'Audit Log';

    // Form definition (empty since we want it to be read-only)
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    // Table definition
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('table_name')->label('Table'),
                TextColumn::make('record_id')->label('Record ID'),
                TextColumn::make('changes')->label('Changes')->limit(100),
                TextColumn::make('changed_by')->label('Changed By'),
                TextColumn::make('created_at')->label('Timestamp'),
            ]);
 
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}

