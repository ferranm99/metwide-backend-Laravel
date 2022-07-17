<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbaToken extends Model
{
    protected $fillable = [
        'account_ucn',
        'account_name',
        'account_type',
        'last_four_digits',
        'token',
        'expiry',
        'payment_type',
        'active',
        'generated_by',
        'updated_by',
    ];

    public function account()
	{
		return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
    }
}
