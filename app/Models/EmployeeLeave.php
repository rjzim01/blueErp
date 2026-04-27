<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    protected $table = 'p_leaves';

    protected $fillable = [
        'yearmonth',
        'outlet',
        'emp_id',
        'title',
        'description',
        'days',
        'status',
        'entry_by',
        'update_by',
    ];
}