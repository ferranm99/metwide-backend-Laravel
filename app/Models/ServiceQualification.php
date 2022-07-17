<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceQualification extends Model
{
    protected $fillable = [
        'broadband_order_id',
        'long_address',
        'latitude',
        'longitude',
        'lot_number',
        'unit_number',
        'unit_number_suffix',
        'unit_type',
        'level_number',
        'level_suffix',
        'level_type',
        'street_number',
        'street_number_suffix',
        'street_number_2',
        'street_number_suffix_2',
        'suburb',
        'state',
        'postcode',
        'location_id',
        'directory_tx_id',
        'qualify_tx_id',
        'result',
        'service_type',
        'service_class',
        'data_port',
        'voice_port',
        'csa',
        'cvcid',
        'zone',
        'voice_cvcid',
        'traffice_class_1',
        'traffice_class_2',
        'traffice_class_3',
        'traffice_class_4',
        'available_ctag',
        'stag',
        'battery',
        'connection_type',
        'development_charge',
        'activation_date',
        'copper_disconnection_date',
        'ntdid',
    ];

    public function vocusCopperPairRecords()
    {
        return $this->hasMany(\App\Models\VocusCopperPairRecord::class);
    }

    public function vocusServiceOrder()
	{
		return $this->hasOne(\App\Models\VocusServiceOrder::class);
    }

    public function nbnPortRecords()
	{
		return $this->hasMany(\App\Models\NBNPortRecord::class);
    }

    public function opticommPortUtlisations()
	{
		return $this->hasMany(\App\Models\opticommPortUtlisation::class);
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
