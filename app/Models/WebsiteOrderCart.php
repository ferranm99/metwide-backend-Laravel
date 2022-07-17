<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteOrderCart extends Model
{
    protected $fillable = [
        'id',
        'site_code',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'address',
        'location_id',
        'service_type',
        'plan_name',
        'connection_type',
        'monthly_data',
        'is_alpha_phone',
        'alpha_phone_plan',
        'international_call_pack',
        'is_modem',
        'token',
        'order_submitted',
        'order_reference',
    ];
}
