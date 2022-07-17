<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPlan extends Model
{

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'name',
        'service_category_id',
        'service_provider_id',
        'smile_plan_id',
        'data_allowance',
        'data_allowance_unit',
        'speed',
        'download_speed',
        'speed_unit',
        'price',
        'gst',
        'wholesale_cost',
        'start_date',
        'end_date',
        'active',
        'is_business',
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(\App\Models\ServiceCategory::class, 'service_category_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(\App\Models\ServiceProvider::class, 'service_provider_id');
    }

    public function smilePlan()
    {
        return $this->belongsTo(\App\Models\SmilePlan::class, 'smile_plan_id');
    }

    public function residentialSitePlans()
    {
        return $this->belongsToMany(\App\Models\ResidentialSitePlan::class, 'data_plan_residential_site_plan', 'data_plan_id', 'site_id');
    }

    public function dataServiceModifications()
    {
        return $this->hasMany(\App\Models\DataServiceModification::class, 'data_plan_id', 'id');
    }
}
