<?php

namespace App\Filament\Exports;

use App\Models\Residents;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ResidentsExporter extends Exporter
{
    protected static ?string $model = Residents::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('lastname'),
            ExportColumn::make('firstname'),
            ExportColumn::make('middlename'),
            ExportColumn::make('gender'),
            ExportColumn::make('birthdate'),
            ExportColumn::make('birthplace'),
            ExportColumn::make('age'),
            ExportColumn::make('address'),
            ExportColumn::make('purok'),
            ExportColumn::make('differently_abled_person'),
            ExportColumn::make('marital_status'),
            ExportColumn::make('bloodtype'),
            ExportColumn::make('occupation'),
            ExportColumn::make('monthly_income'),
            ExportColumn::make('religion'),
            ExportColumn::make('nationality'),
            ExportColumn::make('national_id'),
            ExportColumn::make('philhealth_no'),
            ExportColumn::make('resident_email'),
            ExportColumn::make('contact_number'),
            ExportColumn::make('resident_photo'),
            ExportColumn::make('comment'),
            ExportColumn::make('youth_classification'),
            ExportColumn::make('youth_age_group'),
            ExportColumn::make('educational_background'),
            ExportColumn::make('work_status'),
            ExportColumn::make('is_registered_sk_voter'),
            ExportColumn::make('did_vote_last_sk_election'),
            ExportColumn::make('is_registered_national_voter'),
            ExportColumn::make('vote_times'),
            ExportColumn::make('has_attended_sk_assembly'),
            ExportColumn::make('why_no_assembly'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('health_status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your residents export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
