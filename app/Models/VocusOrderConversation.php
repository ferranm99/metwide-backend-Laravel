<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusOrderConversation extends Model
{
    protected $fillable = [
        'vocus_service_order_id',
        'record_datetime',
        'transaction_substate',
        'message',
    ];

    protected $casts = [
        'record_datetime' => 'datetime',
    ];

    public static function orderColumnName(): string
    {
        return 'record_datetime';
    }

    public function vocusServiceOrder()
    {
        return $this->belongsTo(\App\Models\VocusServiceOrder::class, 'vocus_service_order_id');
    }
}
