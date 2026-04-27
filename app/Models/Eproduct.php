<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eproduct extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'code',
        'base_code',
        'name',
        'description',
        'long_description',
        'category',
        'selling_price',
        'color_id',
        'color',
        'age_range',
        'discount',
        'fabric',
        'measurement',
        'offer',
        'active',
        'current_stock',
        'ecommerce',
        'entry_by',
        'update_by',
    ];

    protected static function booted()
    {
        static::addGlobalScope('ecommerce', function ($query) {
            $query->where('ecommerce', 'yes');
        });
    }
}