<?php

namespace Filament\Widgets;

use App\Models\CertificateRequest;
use Filament\Widgets\ChartWidget;

class CertificatesIssued extends ChartWidget
{
    protected static ?string $heading = 'Certificates Issued Per Month';

  

    protected function getData(): array
    {
        // Fetch issued certificates and group by month
        $issuedCertificates = CertificateRequest::where('status', 'issued')
            ->selectRaw('MONTH(date_recorded) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        // Prepare labels and data for each month
        $labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $data = array_fill(0, 12, 0); // Initialize data array with zeroes for each month

        foreach ($issuedCertificates as $record) {
            $data[$record->month - 1] = $record->count;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Certificates Issued',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
            
        ];
        
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
