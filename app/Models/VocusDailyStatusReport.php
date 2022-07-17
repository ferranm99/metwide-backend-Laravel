<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusDailyStatusReport extends Model
{
    protected $fillable = [
        'subscription_usn',
        'report_date',
        'fin_account_no',
        'prov_account_no',
        'username',
        'access_number',
        'equip_uid',
        'end_customer_uid',
        'plan_code_description',
        'contract_term',
        'costing_start_date',
        'initial_install_date',
        'address',
        'transaction_id',
        'modify_request_type',
        'modify_request_status',
    ];

    protected $casts = [
        'costing_start_date' => 'date',
        'initial_install_date' => 'date',
    ];

    public function subscription()
    {
        return $this->belongsTo(\App\Models\AccountSubscription::class, 'subscription_usn', 'usn');
    }

    public function vocusPlanId()
    {
        return $this->belongsTo(\App\Models\VocusNbnPlanId::class, 'plan_id', 'fibre_plan_id');
    }

    public function vocusNbnOutageRecords()
    {
        return $this->hasMany(\App\Models\VocusNbnOutageRecord::class, 'vocus_service_id');
    }

    public function dataServiceModifications()
    {
        return $this->hasMany(\App\Models\DataServiceModification::class, 'vocus_service_id');
    }
}
