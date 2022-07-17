<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function serviceActivationCharges()
	{
		return $this->hasMany(\App\Models\ServiceActivationCharge::class, 'service_category_id');
    }

    public function dataPlans()
	{
		return $this->hasMany(\App\Models\DataPlan::class, 'service_category_id');
    }

    public function voicePlans()
	{
		return $this->hasMany(\App\Models\VoicePlan::class, 'service_category_id');
    }

    public function residentialSitePlans()
	{
		return $this->hasMany(\App\Models\ResidentialSitePlan::class, 'service_category_id');
    }

    public function smileServices()
    {
        return $this->hasMany(\App\Models\SmileService::class, 'service_category_id');
    }

    public function accountSubscriptions()
    {
        return $this->hasMany(\App\Models\AccountSubscription::class, 'service_category_id');
    }
}
