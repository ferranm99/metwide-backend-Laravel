<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCardPayment extends Model
{
   protected $fillable = [
      'account_ucn',
      'transaction_type',
      'amount',
      'surcharge',
      'captured_amount',
      'token',
      'order_id',
      'transaction_id',
      'result',
      'acquirer_message',
      'transaction_identifier',
      'receipt',
      'authorization_code',
      'response_gateway_code',
      'payment_type',
      'processed_by',
      'date_payment_processed',
      'time_payment_processed',
      'smile_status',
      'error_cause',
      'error_explanation',
      'error_field',
      'error_validation_type',
      'timestamp',
      'source_of_funds',
      'batch_name',
      'batch_status',
      'batch_last_action',
      'acquirer_code',
      'smile_payment_number'
   ];

   public function account()
   {
      return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
   }
}
