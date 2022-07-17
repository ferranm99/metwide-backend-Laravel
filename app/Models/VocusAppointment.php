<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusAppointment extends Model
{
    protected $fillable = [
        'vocus_service_order_id',
        'username',
        'phone',
        'appointment_slot',
        'start_date_time',
        'end_date_time',
        'status',
        'sub_status',
        'site_note',
        'special_condition',
        'demand_type',
        'appointment_sla',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    public function vocusServiceOrder()
    {
        return $this->belongsTo(\App\Models\VocusServiceOrder::class, 'vocus_service_order_id');
    }

    public function vocusAppointmentRecords()
    {
        return $this->hasMany(\App\Models\VocusAppointmentRecord::class, 'vocus_appointment_id');
    }
}
