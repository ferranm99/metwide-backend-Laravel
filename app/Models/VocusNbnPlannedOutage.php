<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusNbnPlannedOutage extends Model
{
    protected $fillable = [
        'outage_id',
        'status',
        'description',
        'location',
        'start_date',
        'end_date',
        'duration',
        'service_id',
        'provider_service_id',
        'report_name'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
