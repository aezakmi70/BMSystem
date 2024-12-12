<?php

namespace Filament\Widgets;

use App\Models\HealthService;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class HealthServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Health Services per Month';

    protected function getData(): array
    {
        // Get the current year
        $startDate = Carbon::now()->startOfYear(); // Start of the current year
        $endDate = Carbon::now()->endOfMonth();  // End of the current month

        // Fetch health services data for the current year
        $data = HealthService::select(
                DB::raw('MONTH(service_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('service_date', [$startDate, $endDate]) // Filter for the current year
            ->groupBy(DB::raw('MONTH(service_date)'))
            ->orderBy(DB::raw('MONTH(service_date)'))
            ->get();

        // Prepare the months array for the entire year (January to December)
        $months = [];
        $counts = [];

        // Loop through all 12 months of the current year
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::now()->month($i)->format('F'); // Get the name of the month
            $months[] = $month;

            // Check if there's data for this month, otherwise default to 0
            $monthData = $data->firstWhere('month', '=', $i);
            $counts[] = $monthData ? $monthData->count : 0; // If no data, use 0
        }

        return [
            'labels' => $months,  // Labels for the bar chart (Month names)
            'datasets' => [
                [
                    'label' => 'Health Services',
                    'data' => $counts,  // Data for the bars (counts of services)
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Bar color
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Bar border color
                    'borderWidth' => 1,
                ]
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';  // Specify the chart type as 'bar'
    }
}
