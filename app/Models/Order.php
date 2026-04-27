<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'fy',
        'date',
        'order_no',
        'customer',
        'mobile',
        'outlet',
        'items',
        'sub_total',
        'discount',
        'delivery_fee',
        'vat',
        'net_payable',
        'paid',
        'delivery_chalan',
        'delivery_channel',
        'pathao_consignment_id',
        'pathao_pickup',
        'remarks',
        'delivered_at',
        'status',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'sub_total' => 'double',
        'discount' => 'double',
        'delivery_fee' => 'double',
        'vat' => 'double',
        'net_payable' => 'double',
        'paid' => 'double',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet', 'id');
    }
}