<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $table = 'stock_transfer';

    protected $fillable = [
        'transfer_code',
        'fy',
        'transfer_from',
        'from_name',
        'transfer_to',
        'to_name',
        'items',
        'status',
        'initiated_by',
        'initiated_name',
        'initiated_date',
        'confirmed_by',
        'confirmed_name',
        'confirmed_date',
        'entry_by',
        'update_by',
    ];
}