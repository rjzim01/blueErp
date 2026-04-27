<?php

namespace App\Filament\Widgets;

use App\Models\Sell;
use App\Models\ProductReturn;
use App\Models\ProductArchive;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class a_3_SalesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today()->format('Y-m-d');

        $todaysSells = Sell::where('date', $today)->get();
        $todaySellCount = $todaysSells->count();
        $todaySellAmount = $todaysSells->sum('payable');
        $todayReturnCount = ProductReturn::where('date', $today)->count();
        $todayReturnAmount = ProductReturn::where('date', $today)->sum('amount');

        $netSellAmount = $todaySellAmount - $todayReturnAmount;

        $todaysSellItems = 0;
        foreach ($todaysSells as $sell) {
            if ($sell->screen_data && isset($sell->screen_data['itemList'])) {
                $todaysSellItems += count($sell->screen_data['itemList']);
            }
        }

        return [
            Stat::make('Today\'s POS Sell', number_format($todaySellAmount, 0) . ' BDT')
                ->description($todaySellCount . ' transactions')
                ->color('success'),
            Stat::make('Today\'s Returns', number_format($todayReturnAmount, 0) . ' BDT')
                ->description($todayReturnCount . ' returns')
                ->color('danger'),
            Stat::make('Net POS Sell', number_format($netSellAmount, 0) . ' BDT')
                ->description($todaysSellItems . ' items sold')
                ->color('primary'),
        ];
    }
}
