<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmilePlan extends Model
{
    protected $fillable = [
        'plan_code',
        'name',
        'smile_service_id',
    ];

    public function smileService()
	{
		return $this->belongsTo(\App\Models\SmileService::class, 'smile_service_id');
    }

    public function dataPlans()
    {
        return $this->hasMany(\App\Models\DataPlan::class, 'smile_plan_id');
    }

    public function voicePlans()
    {
        return $this->hasMany(\App\Models\VoicePlan::class);
    }

    public function supportPackagePlans()
   {
      return $this->hasMany(\App\Models\SupportPackagePlan::class, 'smile_plan_id');
   }
}
