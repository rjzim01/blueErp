# Dashboard Design Specification - Laravel Blade + Tailwind CSS

## Design Prompt for AI

```
Create a blueERP Dashboard page using Laravel Blade + Tailwind CSS with the following sections:

### Section 1: Balance Cards Row (5 cards in grid)

Row of 5 colored cards:
1. Cash Balance - Green background, pie chart icon, large number with "/-" suffix, "View Details" link
2. City Bank Balance - Blue background, stats bars icon, large number with "/-" suffix, "View Details" link
3. DBBL Balance - Yellow/Warning background, person icon, large number with "/-" suffix, "View Details" link
4. Islami Bank - Purple background, person icon, large number with "/-" suffix, "View Details" link
5. Bank Asia - Navy/Default background, person icon, large number with "/-" suffix, "View Details" link

Each card: colored background, white text, rounded-xl, shadow, large bold number, label above, icon on right, footer with "View Details >"

### Section 2: Stats Info Boxes (4 cards in grid)

Row of 4 white cards with colored circular icons on left:
1. Total Available Products - Blue icon (box), label, large number
2. Total Available Barcodes - Red icon (barcode), label, large number, clickable link
3. Number of Today Sell - Green icon (shopping cart), label, large number
4. Number of Today Returns - Yellow icon (users), label, large number

Style: White background, shadow, rounded, absolute positioned colored circle icon on left

### Section 3: POS Stats Cards (6 cards in 3-column grid)

Row of 6 white cards with colored left border:
1. Today POS Sell - Green border, shopping cart icon, amount with "/-" suffix
2. Today POS Returns - Red border, users icon, amount with "/-" suffix
3. Today Net POS Sell - Yellow/Warning border, users icon, amount with "/-" suffix
4. Sold Items - Green border, shopping cart icon, count
5. Return Items - Red border, users icon, count
6. Net Sell Items - Yellow/Warning border, users icon, calculated count

### Section 4: Action Buttons Row

Row of large rounded buttons:
- Download Customer (green)
- Daraz Monthly (yellow/red)
- Go To POS (blue)
- Go To Stock Report (primary blue)
- Go To Old Stock Entry (green)
- Go To Outlet Wise Balance (red)

### Section 5: Data Tables

Two tables with hover effect:

Table 1 - Today Sell Summary:
Columns: SL, Invoice, QTT, Bill, Disc, Net, Paid, Due
Data from: sell_summery collection

Table 2 - Today Return Summary:
Columns: SL, Receipt No., QTT, Amount
Data from: return_summery collection

### Colors:
- Green: #28a745
- Blue: #17a2b8
- Yellow: #ffc107
- Red: #dc3545
- Purple: #6f42c1
- Orange: #ff9900

### Icons: Heroicons or Lucide
- currency-dollar, shopping-cart, users, chart-bar, box, document-text, building-office
```

---

## Layout Structure

```
┌─────────────────────────────────────────────────────────────┐
│  [Cash] [City Bank] [DBBL] [Islami] [Bank Asia]              │
├─────────────────────────────────────────────────────────────┤
│  [Products] [Barcodes] [Today Sell] [Today Returns]          │
├─────────────────────────────────────────────────────────────┤
│  [POS Sell] [POS Returns] [Net Sell] [Sold Items]...       │
├─────────────────────────────────────────────────────────────┤
│  [Download] [Daraz] [Go To POS] [Stock Report]...           │
├─────────────────────────────────────────────────────────────┤
│  ┌─ Today Sell Summary ───────────────────────────────────┐ │
│  │  SL | Invoice | QTT | Bill | Disc | Net | Paid | Due    │ │
│  └────────────────────────────────────────────────────────┘ │
│  ┌─ Today Return Summary ─────────────────────────────────┐ │
│  │  SL | Receipt No. | QTT | Amount                       │ │
│  └────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

---

## Color Palette

| Color | Hex | Usage |
|-------|-----|-------|
| Green | #28a745 | Cash balance, sold items |
| Blue | #17a2b8 | City bank, products |
| Yellow | #ffc107 | DBBL, returns |
| Red | #dc3545 | Damaged, returns |
| Purple | #6f42c1 | Islami bank |
| Orange | #ff9900 | Damaged items |

---

## Data Variables (Blade/PHP)

| Variable | Type | Description |
|----------|------|-------------|
| `cashbalance` | number | Cash balance |
| `citybalance` | number | City Bank balance |
| `dbblbalance` | number | DBBL balance |
| `islamibankbalance` | number | Islami Bank balance |
| `bankasiabalance` | number | Bank Asia balance |
| `products` | number | Total product count |
| `barcodes` | number | Total barcode count |
| `todaysell` | number | Today's sell count |
| `todayreturn` | number | Today's return count |
| `todays_sell_amount` | number | Today's sell amount |
| `todays_return_amount` | number | Today's return amount |
| `todays_sell_qtt` | number | Total sold items |
| `todays_return_qtt` | number | Total return items |
| `net_sell_amount` | number | Calculated: todays_sell_amount - todays_return_amount |
| `net_sell_qtt` | number | Calculated: todays_sell_qtt - todays_return_qtt |
| `sell_summery` | collection | Today's sell records |
| `return_summery` | collection | Today's return records |

---

## Models/Tables to Query

| Variable | Model | Query |
|----------|-------|-------|
| `cashbalance` etc. | `Balance` | Group by `balance_method`, sum `amount` |
| `products` | `ProductArchive` | Count all |
| `barcodes` | `ProductArchive` | Count where barcode not null |
| `todaysell` | `Sell` | Count where `date = today()` |
| `todayreturn` | `ProductReturn` | Count where `date = today()` |
| `sell_summery` | `Sell` | Get today's sells |
| `return_summery` | `ProductReturn` | Get today's returns |

---

## Sample Controller

```php
public function index()
{
    $today = now()->format('Y-m-d');

    // Balance Stats
    $balances = Balance::selectRaw('balance_method, SUM(amount) as total')
        ->groupBy('balance_method')
        ->pluck('total', 'balance_method');

    $cashbalance = $balances[1] ?? 0;
    $citybalance = $balances[2] ?? 0;
    $dbblbalance = $balances[3] ?? 0;
    $islamibankbalance = $balances[4] ?? 0;
    $bankasiabalance = $balances[5] ?? 0;

    // Products Stats
    $products = ProductArchive::count();
    $barcodes = ProductArchive::whereNotNull('barcode')->count();

    // Sales Stats
    $todaysSells = Sell::where('date', $today)->get();
    $todaysell = $todaysSells->count();
    $todays_sell_amount = $todaysSells->sum('payable');

    // Sold Items Count (parse screen_data JSON)
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

    // Return Stats
    $todayreturn = ProductReturn::where('date', $today)->count();
    $todays_return_amount = ProductReturn::where('date', $today)->sum('amount');

    // Return Items Count (parse items JSON)
    $todays_return_qtt = 0;
    $returnSummery = ProductReturn::where('date', $today)->get();
    foreach ($returnSummery as $return) {
        $items = $return->items;
        if (is_string($items)) {
            $items = json_decode($items, true);
        }
        if (is_array($items)) {
            $todays_return_qtt += count($items);
        }
    }

    // Calculated Values
    $net_sell_amount = $todays_sell_amount - $todays_return_amount;
    $net_sell_qtt = $todays_sell_qtt - $todays_return_qtt;

    // Tables Data
    $sell_summery = $todaysSells;
    $return_summery = $returnSummery;

    return view('dashboard.custom', compact(
        'cashbalance', 'citybalance', 'dbblbalance', 'islamibankbalance', 'bankasiabalance',
        'products', 'barcodes', 'todaysell', 'todayreturn',
        'todays_sell_amount', 'todays_return_amount', 'todays_sell_qtt', 'todays_return_qtt',
        'net_sell_amount', 'net_sell_qtt',
        'sell_summery', 'return_summery'
    ));
}
```