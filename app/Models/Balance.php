<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';

    protected $fillable = [
        'outlet',
        'amount',
        'balance_method',
        'method_name',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'amount' => 'double',
    ];
}