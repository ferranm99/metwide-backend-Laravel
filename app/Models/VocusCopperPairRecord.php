<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocusCopperPairRecord extends Model
{
    protected $fillable = [
        'service_qualification_id',
        'copper_pair_id',
        'copper_pair_status',
        'nbn_service_status',
        'pots_interconnect',
        'pots_match',
        'upload_speed',
        'download_speed',
        'network_co_exist',
    ];

    public function serviceQualification()
	{
		return $this->belongsTo(\App\Models\ServiceQualification::class,'service_qualification_id', 'id');
    }
}
