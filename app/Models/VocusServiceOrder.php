<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusServiceOrder extends Model
{
    protected $fillable = [
        'broadband_order_id',
        'order_id',
        'status',
        'service_id',
        'plan_id',
        'realm',
        'order_type',
        'customer_name',
        'phone',
        'password',
        'service_type',
        'data_port_number',
        'cvc_id',
        'ctag',
        'traffic_class_1',
        'traffic_class_2',
        'voice_port_id_1',
        'voice_port_id_2',
        'copper_pair_id',
        'voiceband_continuity',
        'carrier_id',
        'battery',
        'service_level',
        'central_splitter',
        'ntd_id',
        'directory_id',
        'cpe_directory_id',
        'cpe_plan_id',
        'nbn_cpe_plan_id',
        'location_reference',
        'customer_ref',
        'customer_authority_date',
        'nbn_instance_id',
        'data_port_id',
        'avc_id',
        'voice_cvc_id',
        'voice_port_id1_avc_id',
        'voice_port_id2_avc_id',
        'nbn_cpe_service_id',
        'transaction_id',
    ];


    protected $casts = [
        'order_date' => 'date',
        'phone_number' => 'array'
    ];

    public function vocusAppointments()
    {
        return $this->hasMany(\App\Models\VocusAppointment::class, 'vocus_service_order_id');
    }

    public function vocusOrderConversations()
    {
        return $this->hasMany(\App\Models\VocusOrderConversation::class, 'vocus_service_order_id');
    }

    public function vocusOrderSteps()
    {
        return $this->hasMany(\App\Models\VocusOrderStep::class, 'vocus_service_order_id');
    }


    public function residentialOnlineOrder()
    {
        return $this->belongsTo(\App\Models\ResidentialOnlineOrder::class, 'order_id');
    }

    public function broadbandServiceOrder()
    {
        return $this->belongsTo(\App\Models\BroadbandServiceOrder::class, 'broadband_order_id');
    }

}
