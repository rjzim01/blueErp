<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'code',
        'base_code',
        'name',
        'description',
        'long_description',
        'category',
        'type',
        'size',
        'photo',
        'photo1',
        'photo2',
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
        'e_id',
        'e_code',
        'e_variation',
        'outlet',
        'barcode',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'selling_price' => 'integer',
        'current_stock' => 'integer',
        'discount' => 'integer',
        'offer' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }
}