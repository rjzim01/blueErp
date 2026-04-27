<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class a_5_DateRangeSummaryWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Production', '')
                ->url('/admin')
                ->color('primary'),
            Stat::make('Warehouse', '')
                ->url('/admin')
                ->color('warning'),
            Stat::make('Transfer Channel', '')
                ->url('/admin')
                ->color('info'),
            Stat::make('Outlet Stock', '')
                ->url('/admin')
                ->color('success'),
            Stat::make('POS Sell', '')
                ->url('/admin')
                ->color('danger'),
            Stat::make('Order Sell', '')
                ->url('/admin')
                ->color('gray'),
            Stat::make('Damaged', '')
                ->url('/admin')
                ->color('danger'),
        ];
    }

}
