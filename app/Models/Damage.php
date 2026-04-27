<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $table = 'damages';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'barcode_id',
        'product_id',
        'product_name',
        'barcode',
        'code',
        'damage_date',
        'damage_reason',
        'status',
        'entry_by',
    ];

    protected $casts = [
        'damage_date' => 'date',
        'status' => 'integer',
        'product_id' => 'integer',
        'barcode_id' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->entry_by)) {
                $model->entry_by = auth()->id() ?? 1;
            }
            if (empty($model->damage_date)) {
                $model->damage_date = now()->toDateString();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productArchive()
    {
        return $this->belongsTo(ProductArchive::class, 'barcode_id');
    }

    public static function getStatusOptions(): array
    {
        return [
            1 => 'Pending',
            2 => 'Approved',
            3 => 'Rejected',
            4 => 'Resolved',
        ];
    }
}