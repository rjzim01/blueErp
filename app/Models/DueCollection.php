<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueCollection extends Model
{
    protected $table = 'due_collection';

    protected $fillable = [
        'fy',
        'customer',
        'date',
        'amount',
        'entry_by',
        'update_by',
    ];

    public function customerData(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer');
    }
}
