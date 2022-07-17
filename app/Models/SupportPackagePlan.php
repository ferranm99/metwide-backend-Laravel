<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportPackagePlan extends Model
{
   use HasFactory;

   protected $fillable = [
      'name',
      'plan_code',
      'service_category_id',
      'service_provider_id',
      'smile_plan_id',
      'description',
      'price',
      'gst',
      'wholesale_cost',
      'start_date',
      'end_date',
      'active',
   ];

   protected $casts = [
      'start_date' => 'date',
      'end_date' => 'date',
      'active' => 'boolean'
   ];

   public function serviceCategory()
   {
      return $this->belongsTo(\App\Models\ServiceCategory::class, 'service_category_id');
   }

   public function serviceProvider()
   {
      return $this->belongsTo(\App\Models\ServiceProvider::class, 'service_provider_id');
   }

   public function smilePlan()
   {
      return $this->belongsTo(\App\Models\SmilePlan::class, 'smile_plan_id');
   }
}
