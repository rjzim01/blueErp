<?php

namespace App\Filament\Widgets;

use App\Models\ProductArchive;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class a_2_ProductsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $availableProducts = Product::count();

        $availableBarcodes = ProductArchive::where('status', 3)
            ->groupBy('code')
            ->selectRaw('code, count(code) as code_counter')
            ->get()
            ->sum('code_counter');

        return [
            Stat::make('Available Products', number_format($availableProducts))
                ->description('Total products in catalog')
                ->color('info'),
            Stat::make('Available Barcodes', number_format($availableBarcodes))
                ->description('Barcodes ready to sell')
                ->color('warning'),
        ];
    }
}
