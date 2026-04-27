<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBill extends Model
{
    protected $table = 'supplier_bill';

    protected $fillable = [
        'bill_no',
        'supplier',
        'amount',
        'remarks',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'amount' => 'double',
    ];
}