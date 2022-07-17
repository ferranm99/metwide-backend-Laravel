<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'service_order_id',
        'address_type',
        'full_address',
        'street_address',
        'locality_address',
        'address_line_1',
        'address_line_2',
        'plan_number',
        'site_name',
        'lot_number',
        'level_type',
        'level_number',
        'unit_type',
        'unit_number',
        'street_number',
        'street_number_suffix',
        'street_number_2',
        'street_number_suffix_2',
        'street_name',
        'street_type',
        'street_type_suffix',
        'suburb',
        'state',
        'postcode',
    ];

    public function serviceOrder()
	{
		return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }
}
