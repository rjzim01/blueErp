<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class a_4_QuickActionsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Customer', '')
                ->url('/admin')
                ->color('success'),
            Stat::make('Daraz Monthly', '')
                ->url('/admin')
                ->color('success'),
            Stat::make('POS', '')
                ->url('/admin/pos/create')
                ->color('success'),
            Stat::make('Stock Report', '')
                ->url('/admin/stocks')
                ->color('info'),
            Stat::make('Old Stock Entry', '')
                ->url('/admin/stock-entries/create')
                ->color('warning'),
            Stat::make('Outlet Balance', '')
                ->url('/admin/balance')
                ->color('danger'),
        ];
    }

}
