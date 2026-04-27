<?php

namespace App\Filament\Widgets;

use App\Models\Balance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class a_1_BalanceStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $balances = Balance::selectRaw('balance_method, SUM(amount) as total')
            ->groupBy('balance_method')
            ->pluck('total', 'balance_method')
            ->toArray();

        $cash = $balances[1] ?? 0;
        $cityBank = $balances[2] ?? 0;
        $dbbl = $balances[3] ?? 0;
        $islamiBank = $balances[4] ?? 0;
        $bankAsia = $balances[5] ?? 0;

        return [
            Stat::make('Cash Balance', number_format($cash, 0) . ' BDT')
                ->description('Available cash')
                ->color('success'),
            Stat::make('City Bank', number_format($cityBank, 0) . ' BDT')
                ->description('City Bank Balance')
                ->color('info'),
            Stat::make('DBBL', number_format($dbbl, 0) . ' BDT')
                ->description('DBBL Balance')
                ->color('warning'),
            Stat::make('Islami Bank', number_format($islamiBank, 0) . ' BDT')
                ->description('Islami Bank Balance')
                ->color('purple'),
            Stat::make('Bank Asia', number_format($bankAsia, 0) . ' BDT')
                ->description('Bank Asia Balance')
                ->color('danger'),
        ];
    }
}
