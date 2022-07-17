<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{

    protected $casts = [
        'dob' => 'date',
        'submit_date' => 'date',
        'is_business' => 'boolean',
        'is_modem' => 'boolean',
        'modem_order_sent' => 'boolean',
        'draft_order'  => 'boolean',
        'new_billing_account'  => 'boolean',
        'authenticated_user_submit'  => 'boolean',

    ];

    protected $fillable = [
        'account_ucn',
        'modem_order_id',
        'order_reference',
        'provisioning_status',
        'provisioning_sub_status',
        'office_order_file',
        'customer_order_receipt',
        'title',
        'first_name',
        'last_name',
        'dob',
        'email',
        'contact_type',
        'contact_number',
        'contact_mobile_number',
        'contact_work_number',
        'id_type',
        'id_number',
        'is_business',
        'position_title',
        'company_name',
        'company_trading_name',
        'abn',
        'submit_date',
        'referrer_code',
        'cc_token',
        'card_ending',
        'credit_card_type',
        'payment_type',
        'is_modem',
        'modem_cost',
        'modem_order_sent',
        'delivery_cost',
        'modem_order_filename',
        'monthly_cost',
        'total_minimum_cost',
        'total_upfront_charge',
        'username',
        'password',
        'site_code',
        'draft_order',
        'delivery_name',
        'delivery_street_address',
        'delivery_locality_address',
        'new_billing_account',
        'authenticated_user_submit',
        'product_id',
        'order_type'
    ];

    /**
     * Get the name of the email field for the model.
     *
     * @return string
     */
    public function getEmailField(): string
    {
        return 'email';
    }

    public function getFullNameAttribute()
    {

        $fullName = ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);

        return trim($fullName);
    }

    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class, 'service_order_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
    }

    public function modemOrders()
    {
        return $this->hasMany(\App\Models\ModemOrder::class, 'service_order_id', 'id');
    }

    public function broadbandServiceOrders()
    {
        return $this->hasMany(\App\Models\BroadbandServiceOrder::class, 'service_order_id', 'id');
    }

    public function dataServiceModifications()
    {
        return $this->hasMany(\App\Models\DataServiceModification::class, 'service_order_id', 'id');
    }

    public function mobileServiceOrders()
    {
        return $this->hasMany(\App\Models\MobileServiceOrder::class, 'service_order_id', 'id');
    }

    public function voiceServiceOrders()
    {
        return $this->hasMany(\App\Models\VoiceServiceOrder::class, 'service_order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    // Required for SMS system
    protected $appends = ['destination_number'];

    // Required for SMS system
    public function smsMessages()
    {
        return $this->morphMany(\App\Models\SmsMessage::class, 'messageable');
    }

    // Required for SMS system
    public function getDestinationNumberAttribute()
    {
        return $this->contact_number;
    }

    public function getAccountTypeNameAttribute()
    {
        $accountCode = strtoupper(substr($this->order_reference, 0, 3));

        $metwideCompany = \App\Models\MetwideCompany::where('code', $accountCode)->first();

        return $metwideCompany->name ? $metwideCompany->name : '';
    }
}
