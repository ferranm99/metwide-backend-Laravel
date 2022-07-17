<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    protected $fillable = [
        'account_ucn',
        'transaction_number',
        'transaction_type',
        'amount',
        'gst_amount',
        'unallocated_amount',
        'account_type',
        'entry_date',
        'due_date'
    ];

    protected $casts = [
        'entry_date' => 'date',
        'due_date' => 'date'
    ];

    public function account()
	{
		return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
    }

    public function accountType()
	{
		return $this->belongsTo(\App\Models\AccountType::class, 'account_type', 'account_type');
	}
}
