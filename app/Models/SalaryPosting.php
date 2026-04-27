<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPosting extends Model
{
    protected $table = 'p_salary_postings';

    protected $fillable = [
        'posting_no',
        'yearmonth',
        'outlet',
        'emp_id',
        'items',
        'net_payable',
        'status',
        'entry_by',
        'update_by',
    ];

    protected $casts = [
        'net_payable' => 'double',
    ];
}