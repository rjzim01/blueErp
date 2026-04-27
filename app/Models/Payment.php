<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'fy',
        'date',
        'payment_no',
        'balance_tran_no',
        'balance_method',
        'payment_method',
        'order_no',
        'outlet',
        'amount',
        'type',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'amount' => 'double',
    ];
}