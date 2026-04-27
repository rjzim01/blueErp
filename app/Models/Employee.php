<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'p_employees';

    protected $fillable = [
        'uid',
        'bioid',
        'outlet',
        'name',
        'designation',
        'type',
        'salary',
        'vacations',
        'vacation_remains',
        'check_in_time',
        'check_out_time',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'salary' => 'integer',
        'vacations' => 'integer',
        'vacation_remains' => 'integer',
    ];
}