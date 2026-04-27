<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'color';

    protected $fillable = [
        'name',
        'entry_by',
        'update_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'color_id', 'id');
    }
}