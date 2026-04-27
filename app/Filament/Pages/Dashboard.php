<?php

namespace App\Filament\Pages;

use App\Models\Balance;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\ProductArchive;
use App\Models\ProductReturn;
use App\Models\Sell;
use App\Models\StockEntry;
use App\Models\StockTransfer;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = -2;

    public $fromDate;
    public $toDate;
    public $distribution = [];
    public $outlet_wise_sell = [];
    public $outlet_wise_report_summery = [];

    public function mount()
    {
        $this->fromDate = Carbon::today()->startOfMonth()->format('Y-m-d');
        $this->toDate = Carbon::today()->format('Y-m-d');
        $this->loadDistributionData();
    }

    public function loadDistributionData()
    {
        $from = $this->fromDate;
        $to = $this->toDate;

        // Total Production (Stock Entries) - uses entry_at
        $total_prduction = StockEntry::whereBetween('entry_at', [$from, $to])->count();

        // Warehouse - count
        $total_warehouse = StockEntry::whereBetween('entry_at', [$from, $to])->count();

        // Transfer Channel - count
        $total_transfer = StockTransfer::whereBetween('initiated_date', [$from, $to])->count();

        // Outlet Stock - count
        $total_outlet_stock = ProductArchive::where('status', 1)->count();

        // Warehouse Amount - sum of total column
        $warehouse_amount = StockEntry::whereBetween('entry_at', [$from, $to])->sum('total');

        // POS Sell - uses date
        $total_sold = Sell::whereBetween('date', [$from, $to])->sum('payable');

        // Order Sell - uses date
        $total_order = Order::whereBetween('date', [$from, $to])->sum('net_payable');

        // Damaged
        $total_damaged = ProductArchive::where('status', 4)->count();

        // Stock Error (calculated)
        $stock_error = $total_prduction - $total_damaged - $total_order - $total_sold - $total_outlet_stock - $total_transfer - $total_warehouse;

        $this->distribution = [
            'total_prduction' => $total_prduction,
            'total_warehouse' => $total_warehouse,
            'warehouse_amount' => $warehouse_amount,
            'total_transfer' => $total_transfer,
            'total_outlet_stock' => $total_outlet_stock,
            'total_sold' => $total_sold,
            'total_order' => $total_order,
            'total_damaged' => $total_damaged,
            'stock_error' => max(0, $stock_error),
        ];

        // Outlet Wise Summary - exclude id <= 0 (like 'All' outlet)
        $outlets = Outlet::where('id', '>', 0)->get();
        $outletData = [];
        $totals = [
            'pos_ttl' => 0,
            'order_ttl' => 0,
            'ret_ttl' => 0,
            'cancel_ttl' => 0,
            'expense_ttl' => 0,
        ];

        foreach ($outlets as $outlet) {
            $pos_sell = Sell::where('outlet', $outlet->id)
                ->whereBetween('date', [$from, $to])
                ->sum('payable');

            $order_sell = Order::where('outlet', $outlet->id)
                ->whereBetween('date', [$from, $to])
                ->sum('net_payable');

            $return = ProductReturn::where('outlet', $outlet->id)
                ->whereBetween('date', [$from, $to])
                ->sum('amount');

            $order_cancelled = Order::where('outlet', $outlet->id)
                ->whereBetween('date', [$from, $to])
                ->where('status', 'Canceled')
                ->sum('net_payable');

            $expense = Expense::where('outlet', $outlet->id)
                ->whereBetween('entry_at', [$from, $to])
                ->sum('amount');

            $net_sell = $pos_sell + $order_sell - $return - $order_cancelled;

            $outletData[] = [
                'id' => $outlet->id,
                'name' => $outlet->name,
                'pos_sell' => $pos_sell,
                'order_sell' => $order_sell,
                'return' => $return,
                'order_cancelled' => $order_cancelled,
                'net_sell' => $net_sell,
                'expense' => $expense,
            ];

            $totals['pos_ttl'] += $pos_sell;
            $totals['order_ttl'] += $order_sell;
            $totals['ret_ttl'] += $return;
            $totals['cancel_ttl'] += $order_cancelled;
            $totals['expense_ttl'] += $expense;
        }

        $this->outlet_wise_sell = $outletData;
        $this->outlet_wise_report_summery = $totals;
    }

    public function updatedFromDate()
    {
        $this->loadDistributionData();
    }

    public function updatedToDate()
    {
        $this->loadDistributionData();
    }

    public function getViewData(): array
    {
        $today = Carbon::today();
        $chart_data = $this->getChartData($today);

        // Balance data
        $balances = Balance::selectRaw('balance_method, SUM(amount) as total')
            ->groupBy('balance_method')
            ->pluck('total', 'balance_method')
            ->toArray();

        $cashbalance = $balances[1] ?? 0;
        $citybalance = $balances[2] ?? 0;
        $dbblbalance = $balances[3] ?? 0;
        $islamibankbalance = $balances[4] ?? 0;
        $bankasiabalance = $balances[6] ?? 0;

        // Product stats
        $products = Product::count();
        $barcodes = ProductArchive::where('status', 3)
            ->groupBy('code')
            ->selectRaw('code, count(code) as code_counter')
            ->get()
            ->sum('code_counter');

        // Today's sell data
        $todaysSells = Sell::where('date', $today->format('Y-m-d'))->get();
        $todaysell = $todaysSells->count();
        $todays_sell_amount = $todaysSells->sum('payable');

        // Calculate sold items
        $todays_sell_qtt = 0;
        foreach ($todaysSells as $sell) {
            $screenData = $sell->screen_data;
            if (is_string($screenData)) {
                $screenData = json_decode($screenData, true);
            }
            if ($screenData && isset($screenData['itemList'])) {
                $todays_sell_qtt += count($screenData['itemList']);
            }
        }

        // Today's return data
        $todaysReturns = ProductReturn::where('date', $today)->get();
        $todayreturn = $todaysReturns->count();
        $todays_return_amount = $todaysReturns->sum('amount');

        // Calculate return items
        $todays_return_qtt = 0;
        foreach ($todaysReturns as $return) {
            $items = $return->items;
            if (is_string($items)) {
                $items = json_decode($items, true);
            }
            if (is_array($items)) {
                $todays_return_qtt += count($items);
            }
        }

        // Net calculations
        $net_sell_amount = $todays_sell_amount - $todays_return_amount;
        $net_sell_qtt = $todays_sell_qtt - $todays_return_qtt;

        // Summary data for tables
        $sell_summery = $todaysSells;
        $return_summery = $todaysReturns;

        return [
            'cashbalance' => $cashbalance,
            'citybalance' => $citybalance,
            'dbblbalance' => $dbblbalance,
            'islamibankbalance' => $islamibankbalance,
            'bankasiabalance' => $bankasiabalance,
            'products' => $products,
            'barcodes' => $barcodes,
            'todaysell' => $todaysell,
            'todayreturn' => $todayreturn,
            'todays_sell_amount' => $todays_sell_amount,
            'todays_return_amount' => $todays_return_amount,
            'todays_sell_qtt' => $todays_sell_qtt,
            'todays_return_qtt' => $todays_return_qtt,
            'net_sell_amount' => $net_sell_amount,
            'net_sell_qtt' => $net_sell_qtt,
            'sell_summery' => $sell_summery,
            'return_summery' => $return_summery,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'distribution' => $this->distribution,
            'outlet_wise_sell' => $this->outlet_wise_sell,
            'outlet_wise_report_summery' => $this->outlet_wise_report_summery,
            'chart_data' => $chart_data,
        ];
    }

    protected function getChartData($today)
    {
        $dates = [];
        $posData = [];
        $orderData = [];
        $netData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $dates[] = $date;

            $posSell = Sell::where('date', $date)->sum('payable');
            $orderSell = Order::where('date', $date)->sum('net_payable');

            $posData[] = (float) $posSell;
            $orderData[] = (float) $orderSell;
            $netData[] = (float) ($posSell + $orderSell);
        }

        return [
            'dates' => $dates,
            'pos' => $posData,
            'order' => $orderData,
            'net' => $netData,
        ];
    }
}
