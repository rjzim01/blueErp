<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'p_attendances';

    protected $fillable = [
        'ip',
        'uid',
        'emp_id',
        'bioid',
        'date',
        'type',
        'medium',
    ];
}