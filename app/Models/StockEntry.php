<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    protected $table = 'stock_entry';

    protected $fillable = [
        'fy',
        'statement',
        'items',
        'total',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'total' => 'double',
    ];
}