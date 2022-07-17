<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusNbnPlanId extends Model
{
    protected $fillable = [
        'fibre_plan_id',
        'product_id',
        'technology',
        'profile',
        'line_speed',
        'speed_tier',
        'active'
    ];

    public function vocusServices()
    {
        return $this->hasMany(\App\Models\VocusDailyStatusReport::class, 'plan_id', 'fibre_plan_id');
    }
}
