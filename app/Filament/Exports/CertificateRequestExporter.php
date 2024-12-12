<?php

namespace App\Filament\Exports;

use App\Models\CertificateRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CertificateRequestExporter extends Exporter
{
    protected static ?string $model = CertificateRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('residentid'),
            ExportColumn::make('resident_age'),
            ExportColumn::make('resident_birthdate'),
            ExportColumn::make('resident_name'),
            ExportColumn::make('certificate_to_issue'),
            ExportColumn::make('purpose'),
            ExportColumn::make('or_no'),
            ExportColumn::make('samount'),
            ExportColumn::make('date_recorded'),
            ExportColumn::make('recorded_by'),
            ExportColumn::make('status'),
            ExportColumn::make('business_name'),
            ExportColumn::make('business_address'),
            ExportColumn::make('type_of_business'),
            ExportColumn::make('present_official'),
            ExportColumn::make('official_position'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your certificate request export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
