<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'tracking_no',
        'mobile',
        'packet_no',
        'order_no',
        'channel_id',
        'channel_name',
        'channel_uid',
        'remarks',
        'photo',
        'delivery_boy_id',
        'delivery_boy_name',
        'approval_waiting',
        'status',
        'entry_by',
        'update_by',
    ];
}