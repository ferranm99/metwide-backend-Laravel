<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusNbnOutageRecord extends Model
{
    protected $fillable = [
        'vocus_service_id',
        'event_id',
        'status',
        'description',
        'start_date_time',
        'end_date_time',
        'duration',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    public function vocusService()
    {
        return $this->belongsTo(\App\Models\VocusDailyStatusReport::class, 'vocus_service_id');
    }
}
