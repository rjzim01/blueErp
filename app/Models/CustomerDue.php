<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDue extends Model
{
    protected $table = 'customer_due';

    protected $fillable = [
        'fy',
        'customer',
        'c_name',
        'invoice',
        'due',
        'entry_by',
        'update_by',
    ];

    protected function casts(): array
    {
        return [
            'due' => 'decimal:2',
        ];
    }

    public function customerData(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer');
    }
}
