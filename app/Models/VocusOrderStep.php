<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusOrderStep extends Model
{

    protected $fillable = [
        'vocus_service_order_id',
        'step',
        'status',
    ];

    public function vocusServiceOrder()
    {
        return $this->belongsTo(\App\Models\VocusServiceOrder::class, 'vocus_service_order_id');
    }
}
