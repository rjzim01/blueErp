<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';

    protected $fillable = [
        'name',
        'slug',
        'remarks',
        'parent',
        'entry_by',
        'update_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent', 'id');
    }
}