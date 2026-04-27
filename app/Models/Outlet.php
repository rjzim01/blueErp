<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlets';

    protected $fillable = [
        'outlet_manager',
        'name',
        'mobile',
        'pathao_store_id',
        'description',
        'description2',
        'active',
        'entry_by',
        'update_by',
    ];
}