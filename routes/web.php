<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect()->route("filament.admin.pages.dashboard");
});

Route::get('/downloads/receipt/sell/invoice/threeinch/{id}', function ($id) {
    $sell = \App\Models\Sell::find($id);
    if (!$sell) {
        return 'Sale not found';
    }
    
    $items = is_array($sell->items) ? $sell->items : json_decode($sell->items, true);
    
    $html = '<html><head><style>
        body { font-family: monospace; font-size: 12px; width: 80mm; }
        table { width: 100%; }
        td { padding: 2px; }
    </style></head><body>';
    $html .= '<center>================================<br/>';
    $html .= 'SALES RECEIPT<br/>';
    $html .= '================================<br/><br/>';
    $html .= 'Inv: ' . $sell->invoice_no . '<br/>';
    $html .= 'Date: ' . $sell->entry_at . '<br/><br/>';
    $html .= '--------------------------------<br/>';
    
    foreach ($items as $item) {
        $html .= htmlspecialchars($item['product_name']) . '<br/>';
        $html .= '1 x ' . $item['unit_price'] . ' = ' . $item['total_price'] . '<br/>';
    }
    
    $html .= '--------------------------------<br/>';
    $html .= 'Subtotal: ' . $sell->amount . '<br/>';
    if ($sell->discount > 0) {
        $html .= 'Discount: ' . $sell->discount . '<br/>';
    }
    if ($sell->vat > 0) {
        $html .= 'VAT: ' . $sell->vat . '<br/>';
    }
    $html .= '<b>Total: ' . $sell->payable . '</b><br/>';
    $html .= '--------------------------------<br/>';
    $html .= 'Paid: ' . $sell->paid . '<br/>';
    if ($sell->due > 0) {
        $html .= 'Due: ' . $sell->due . '<br/>';
    }
    $html .= '<br/><center>Thank You!<br/>Come Again</center></center></body></html>';
    
    return $html;
});