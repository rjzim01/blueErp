# blueERP V3 Dashboard Design Specification

## Current Implementation

**5 Balance Cards:** Cash Balance, City Bank, DBBL, Islami Bank, Bank Asia

**3 Sales Stats Cards:** Today's POS Sell, Today's Returns, Net POS Sell

**6 Quick Action Cards:** Customer, Daraz Monthly, POS, Stock Report, Old Stock Entry, Outlet Balance

---

## Prompt for Stitch

```
Create a modern ERP admin dashboard with Tailwind CSS featuring:

**Top Section - Balance Overview (5 cards in grid):**
Row of 5 colored stat cards:
1. Cash Balance - Green background, currency icon, shows amount in BDT
2. City Bank - Blue background, building icon, shows amount in BDT  
3. DBBL - Yellow background, mobile money icon, shows amount in BDT
4. Islami Bank - Purple background, bank icon, shows amount in BDT
5. Bank Asia - Red background, bank icon, shows amount in BDT

Each card: white text, rounded-lg, shadow, large number, "BDT" suffix

**Middle Section - Sales Stats (3 cards):**
1. Today's POS Sell - Green, shopping cart icon, shows amount and transaction count
2. Today's Returns - Red, return arrow icon, shows amount and return count
3. Net POS Sell - Blue/Primary, chart icon, shows net amount and items count

**Bottom Section - Quick Actions (6 clickable cards):**
Grid of 6 action cards with links:
1. Customer (green, users icon) → /admin
2. Daraz Monthly (green, cloud icon) → /admin
3. POS (green, cart icon) → /admin/pos/create
4. Stock Report (blue, document icon) → /admin/stocks
5. Old Stock Entry (yellow, box icon) → /admin/stock-entries/create
6. Outlet Balance (red, chart bar icon) → /admin/balance

Each action card: white icon, subtle background color, rounded-lg, hover effect

Use Heroicons for icons, rounded-xl corners, subtle shadows, modern admin dashboard aesthetic.
```

---

## Color Palette

| Purpose | Tailwind Class |
|---------|----------------|
| Success/Money | `bg-green-500` |
| Info/Bank | `bg-blue-500` |
| Warning/Pending | `bg-yellow-500` |
| Danger/Error | `bg-red-500` |
| Special | `bg-purple-500` |

## Icons (Heroicons)

- `currency-dollar` - Money/balance
- `building-office` - Bank
- `shopping-cart` - Sales
- `arrow-uturn-left` - Returns
- `chart-bar` - Stats
- `box` - Products
- `document-text` - Reports
- `users` - Customer

## Tailwind Classes Reference

```html
<!-- Balance Card -->
<div class="bg-green-500 rounded-xl shadow p-6">
    <p class="text-white text-sm">Cash Balance</p>
    <p class="text-white text-2xl font-bold">125,000 BDT</p>
</div>

<!-- Sales Stat Card -->
<div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
    <div class="flex items-center gap-4">
        <div class="p-3 bg-green-100 rounded-full">
            <x-icon name="shopping-cart" class="w-6 h-6 text-green-600" />
        </div>
        <div>
            <p class="text-gray-500 text-sm">Today's POS Sell</p>
            <p class="text-2xl font-bold text-gray-900">45,000 BDT</p>
            <p class="text-sm text-gray-400">12 transactions</p>
        </div>
    </div>
</div>

<!-- Quick Action Card -->
<a href="/admin/pos/create" class="block bg-green-500 hover:bg-green-600 rounded-xl p-6 text-center transition">
    <x-icon name="shopping-cart" class="w-8 h-8 text-white mx-auto mb-2" />
    <p class="text-white font-medium">POS</p>
</a>
```