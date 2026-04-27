<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $fillable = [
        'name',
        'supplier_code',
        'dues',
        'mobile',
        'address',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'dues' => 'double',
    ];
}