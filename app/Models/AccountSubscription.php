<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountSubscription extends Model
{
    public function smilePlan()
    {
        return $this->belongsTo(\App\Models\SmilePlan::class, 'smile_plan_id');
    }

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
    }
}
