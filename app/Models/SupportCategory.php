<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    protected $fillable = ['title', 'slug', 'parent_id', 'description'];

    public function parent()
    {
        return $this->belongsTo('App\Models\SupportCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\SupportCategory', 'parent_id');
    }
}
