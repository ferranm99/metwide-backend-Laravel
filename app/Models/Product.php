<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'supplier_id',
        'type',
        'model',
        'version',
        'description',
        'unit_price',
        'retail_price',
        'current_stock',
        'current_stock_total',
        'min_stock_required',
        'quantity_ordered',
        'code'
    ];

    protected $casts = [
        'current_stock' => 'json',
    ];

    public function supplier()
	{
		return $this->belongsTo(\App\Models\Supplier::class);
    }

    public function modemOrders()
    {
        return $this->hasMany(\App\Models\ModemOrder::class, 'product_id', 'id');
    }

    public function smileInvoiceItemMapping()
   {
      return $this->hasOne(\App\Models\SmileInvoiceItemMapping::class);
   }

   public function serviceOrders()
   {
      return $this->hasMany(\App\Models\ServiceOrder::class, 'product_id', 'id');
   }

}
