<?php

namespace Filament\Widgets;

use App\Models\BlotterRecords;
use App\Models\CertificateRequest;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnresolvedBlotterRecordsAndCertificateRevenue extends BaseWidget
{
    protected function getStats(): array
    {
        //Certificate Request
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalAmountThisMonth = CertificateRequest::where('status', 'issued')
            ->whereMonth('date_recorded', $currentMonth)
            ->whereYear('date_recorded', $currentYear)
            ->sum('samount');

        // Blotter records
        $unresolvedCount = BlotterRecords::where('status', '!=', 'resolved')->count();
        $latestUnresolved = BlotterRecords::where('status', '!=', 'resolved')->latest()->first();

        return [
            Stat::make('Unresolved Blotter Records', $unresolvedCount)
                ->description('Total unresolved blotter records')
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger'),

            Stat::make('Latest Unresolved Incident', $latestUnresolved ? $latestUnresolved->incident_date->format('Y-m-d') : 'N/A')
                ->description($latestUnresolved ? 'Incident at ' . $latestUnresolved->incident_location : 'No unresolved incidents')
                ->icon('heroicon-o-calendar')
                ->color('warning'),
                Stat::make('Total Revenue This Month', '₱' . number_format($totalAmountThisMonth, 2))
                ->description('Total amount for issued certificates this month')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
        ];
    }
}
