<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NbnInterestRegister extends Model
{

    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'location_id',
        'available_date',
        'nbnco_service_status',
        'network_type',
        'connection_type',
        'service_available',
        'update_status',
    ];

    protected $casts = [
        'available_date' => 'date',
        'service_available' => 'boolean'
    ];
}
