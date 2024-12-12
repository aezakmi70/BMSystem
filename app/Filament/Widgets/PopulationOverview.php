<?php

namespace Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use App\Models\Residents;

class PopulationOverview extends BaseWidget
{
    use HasWidgetShield;
    protected int|string|array $columnSpan = 2;
    protected function getStats(): array
    {
      
        $totalPopulation = Residents::count();
    
       
        $youths = Residents::whereBetween('age', [15, 30])->count();
    
      
        $seniors = Residents::where('age', '>=', 60)->count();
    
       
        return [
            Stat::make('Residents', $totalPopulation)
            ->description('Total Population')
            ->chart([50,2,80,20,20,30,90,20,60])
            ->color('primary'), 
            Stat::make('Sangguniang Kabataan', $youths)
            ->description('Youth Populaton (ages 15-30)')
            ->chart([30,2,60,20,40,30,90,10,60])
            ->color('info'),           
            Stat::make('Seniors', $seniors)
            ->description('Senior Citizens (Ages 60+)')
            ->chart([30,2,60,20,40,30,90,10,60])
            ->color('warning'),
        ];
    }
    
    
    
}
