<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Barryvdh\Debugbar\Facade as Debugbar;

class BroadbandServiceOrder extends Model
{
    protected $casts = [
        'require_static_ip' => 'boolean',
        'transfer_service' => 'boolean',
        'connect_new_service' => 'boolean',
        'require_new_cpi' => 'boolean',
        'draft_order'  => 'boolean',
    ];

    protected $fillable = [
        'service_order_id',
        'data_plan_id',
        'subscription_usn',
        'service_order_reference',
        'provisioning_status',
        'provisioning_sub_status',
        'billing_status',
        'monthly_plan_fee',
        'service_number',
        'connection_type',
        'require_static_ip',
        'static_ip_monthly_fee',
        'min_monthly_cost',
        'qualification_id',
        'transfer_service',
        'connect_new_service',
        'require_new_cpi',
        'new_cpi_charge',
        'nbn_cpe_plan_id',
        'data_port_number',
        'ntdid',
        'copper_pair_id',
        'order_tx_id',
        'username',
        'password',
        'location_id',
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
        'suburb',
        'state',
        'postcode',
        'service_contact_first_name',
        'service_contact_last_name',
        'service_contact_phone_number',
        'service_contact_mobile_number',
        'service_contact_email',
        'draft_order',
        'activation_fee',
        'plan_name',
        'support_package_plan_id',
        'customer_reference_number'
    ];


    public function serviceOrder()
    {
        return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }

    public function dataPlan()
    {
        return $this->belongsTo(\App\Models\DataPlan::class, 'data_plan_id', 'id');
    }

    public function supportPackagePlan()
   {
      return $this->belongsTo(\App\Models\SupportPackagePlan::class, 'support_package_plan_id', 'id');
   }

    public function subscription()
    {
        return $this->belongsTo(\App\Models\AccountSubscription::class, 'subscription_usn', 'usn');
    }

    public function serviceQualifications()
    {
        return $this->hasMany(\App\Models\ServiceQualification::class, 'broadband_order_id');
    }

    public function vocusServiceOrders()
    {
        return $this->hasMany(\App\Models\VocusServiceOrder::class, 'broadband_order_id');
    }
}
