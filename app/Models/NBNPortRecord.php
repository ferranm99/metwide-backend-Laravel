<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NBNPortRecord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nbn_port_records';

    protected $fillable = [
        'service_qualification_id',
        'ntdid',
        'port_number',
        'port_name',
        'available',
        'port_type'
    ];

    public function serviceQualification()
	{
		return $this->belongsTo(\App\Models\ServiceQualification::class);
    }
}
