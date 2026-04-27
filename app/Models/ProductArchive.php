<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductArchive extends Model
{
    protected $table = 'product_archive';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'fy',
        'ptype',
        'barcode',
        'code',
        'name',
        'price',
        'purchase',
        'outlet_id',
        'outlet_name',
        'audit_outlet_id',
        'audit_outlet_name',
        'audit_at',
        'audit_status',
        'supplier_id',
        'supplier_name',
        'entry_statement',
        'transfer',
        'transfer_statement',
        'sell',
        'sell_statement',
        'return',
        'status',
        'prod_emp',
        'prod_cat',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'price' => 'double',
        'purchase' => 'double',
        'audit_at' => 'datetime',
        'entry_at' => 'datetime',
        'update_at' => 'datetime',
    ];
}