<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportQuestion extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\SupportCategory');
    }
}
