<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected $table = 'product_returns';
    protected $guarded = ['id'];

    protected $casts = [
        'items' => 'array',
        'screen_data' => 'array',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }
}