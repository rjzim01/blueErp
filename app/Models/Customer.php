<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'customers';
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'deliveryaddress',
        'dues',
        'entry_by',
        'update_by',
    ];

    protected function casts(): array
    {
        return [
            'dues' => 'decimal:2',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer');
    }

    public function customerDues(): HasMany
    {
        return $this->hasMany(CustomerDue::class);
    }

    public function dueEntries(): HasMany
    {
        return $this->hasMany(DueEntry::class);
    }

    public function dueCollections(): HasMany
    {
        return $this->hasMany(DueCollection::class);
    }
}