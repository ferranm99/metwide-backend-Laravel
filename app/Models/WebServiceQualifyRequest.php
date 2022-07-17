<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebServiceQualifyRequest extends Model
{
    protected $fillable = [
        'address',
        'location_id',
        'status',
        'access_type',
        'qualification_id',
        'speeds_list',
        'start_time',
        'duration',
        'page_source',
        'service',
        'site',
    ];
}
