<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class MobileServiceOrder extends Model
{
    protected $casts = [
        'is_port_number' => 'boolean',
        'sim_activation_sent' => 'boolean',
        'dob_on_current_account' => 'date',
        'draft_order'  => 'boolean',
    ];

    protected $fillable = [
        'service_order_id',
        'mobile_plan_id',
        'subscription_usn',
        'service_order_reference',
        'provisioning_status',
        'provisioning_sub_status',
        'billing_status',
        'monthly_plan_fee',
        'min_monthly_cost',
        'activation_fee',
        'mobile_number',
        'is_port_number',
        'current_provider',
        'current_account_number',
        'current_mobile_plan',
        'dob_on_current_account',
        'sim_card_no',
        'sim_delivery_letter',
        'sim_activation_sent',
        'service_contact_first_name',
        'service_contact_last_name',
        'service_contact_phone_number',
        'service_contact_mobile_number',
        'service_contact_email',
        'draft_order',
        'plan_name'
    ];


    public function serviceOrder()
    {
        return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }

    public function mobilePlan()
    {
        return $this->belongsTo(\App\Models\MobilePlan::class, 'mobile_plan_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(\App\Models\AccountSubscription::class, 'subscription_usn', 'usn');
    }
}
