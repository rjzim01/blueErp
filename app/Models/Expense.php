<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expense';

    protected $fillable = [
        'expense_sector',
        'outlet',
        'method',
        'from_balance',
        'status',
        'approved_by',
        'approved_at',
        'amount',
        'remarks',
        'receipt_no',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'amount' => 'double',
    ];
}