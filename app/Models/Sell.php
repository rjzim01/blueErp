<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $table = 'sell';
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
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

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }
}