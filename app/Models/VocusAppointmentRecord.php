<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusAppointmentRecord extends Model
{
    protected $fillable = [
        'vocus_appointment_id',
        'record_datetime',
        'appointment_slot',
        'start_date_time',
        'end_date_time',
        'status',
        'sub_status',
    ];

    protected $casts = [
        'record_datetime' => 'datetime',
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    public static function orderColumnName(): string
    {
        return 'record_datetime';
    }

    public function vocusAppointment()
    {
        return $this->belongsTo(\App\Models\VocusAppointment::class, 'vocus_appointment_id');
    }
}
