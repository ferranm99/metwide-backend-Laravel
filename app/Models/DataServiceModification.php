<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataServiceModification extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_order_id',
        'vocus_service_id',
        'data_plan_id',
        'current_speed',
        'provisioning_status',
        'provisioning_sub_status',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }

    public function vocusService()
    {
        return $this->belongsTo(\App\Models\VocusDailyStatusReport::class, 'vocus_service_id', 'id');
    }

    public function dataPlan()
    {
        return $this->belongsTo(\App\Models\DataPlan::class, 'data_plan_id', 'id');
    }
}
