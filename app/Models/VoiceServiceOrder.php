<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceServiceOrder extends Model
{

    protected $casts = [
        'is_international_call_pack' => 'boolean',
        'is_port_number'  => 'boolean',
        'draft_order'  => 'boolean',
    ];

    protected $fillable = [
        'service_order_id',
        'voice_plan_id',
        'subscription_usn',
        'service_order_reference',
        'provisioning_status',
        'provisioning_sub_status',
        'billing_status',
        'monthly_plan_fee',
        'phone_number_min',
        'phone_number_max',
        'is_international_call_pack',
        'monthly_call_pack_fee',
        'min_monthly_cost',
        'is_port_number',
        'current_provider',
        'current_account_number',
        'location_id',
        'telstra_id',
        'full_address',
        'street_address',
        'locality_address',
        'address_line_1',
        'address_line_2',
        'plan_number',
        'site_name',
        'lot_number',
        'level_type',
        'level_number',
        'unit_type',
        'unit_number',
        'street_number',
        'street_number_suffix',
        'street_number_2',
        'street_number_suffix_2',
        'street_name',
        'street_type',
        'street_type_suffix',
        'suburb', 'state',
        'postcode',
        'service_contact_first_name',
        'service_contact_last_name',
        'service_contact_phone_number',
        'service_contact_mobile_number',
        'service_contact_email',
        'draft_order',
        'activation_fee',
        'plan_name'
    ];


    public function serviceOrder()
    {
        return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }

    public function voicePlan()
    {
        return $this->belongsTo(\App\Models\VoicePlan::class, 'voice_plan_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(\App\Models\AccountSubscription::class, 'subscription_usn', 'usn');
    }
}
