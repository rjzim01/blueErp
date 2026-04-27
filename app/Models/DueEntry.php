<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueEntry extends Model
{
    protected $table = 'due_entry';

    protected $fillable = [
        'fy',
        'customer',
        'invoice',
        'amount',
        'entry_by',
        'update_by',
    ];

    public function customerData(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer');
    }
}
