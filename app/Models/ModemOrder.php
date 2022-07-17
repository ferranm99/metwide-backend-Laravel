<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModemOrder extends Model
{
    protected $fillable = [
        'subscription_usn',
        'service_order_id',
        'product_id',
        'order_number',
        'order_date',
        'first_name',
        'last_name',
        'company',
        'street_address',
        'suburb',
        'state',
        'postcode',
        'customer_email',
        'customer_phone_number',
        'product_required',
        'internet_connection',
        'vlan_id',
        'isp_user_account',
        'isp_user_password',
        'wifi_name',
        'wifi_password',
        'voip_user_name_account_1)',
        'voip_password_account_1)',
        'voip_user_name_account_2',
        'voip_password_account_2',
        'sip_roxy',
        'sip_port',
        'remote_access',
        'local_management_port_number',
        'remote_management_port_number',
        'remote_ip_address',
        'local_icmp_ping',
        'Remote_icmp_ping',
        'modem_user',
        'modem_password',
        'notes',
        'mac_address',
        'serial_number',
        'tracking_number',
        'modem_order_sent',
        'delivery_name',
        'payment_processed'
    ];

    protected $casts = [
        'order_date' => 'date',
        'dispatch_date' => 'date',
        'modem_order_sent' => 'boolean',
        'payment_processed' => 'boolean'
    ];

    // Required for SMS system
    protected $appends = ['destination_number'];

    public function getAccountTypeNameAttribute()
    {
        $accountCode = strtoupper(substr($this->order_number, 0, 3));

        $metwideCompany = \App\Models\MetwideCompany::where('code', $accountCode)->first();

        return $metwideCompany->name ? $metwideCompany->name : '';
    }

    public function getSupportPhoneNumberAttribute()
    {
        $accountCode = strtoupper(substr($this->order_number, 0, 3));

        $metwideCompany = \App\Models\MetwideCompany::where('code', $accountCode)->first();

        return $metwideCompany->public_phone ? $metwideCompany->public_phone : '1300 300 210';
    }

    // Required for SMS system
    public function getDestinationNumberAttribute()
    {
        return $this->customer_phone_number;
    }

    public function getDeliveryAddressAttribute()
    {
        return $this->street_address . ' ' . $this->suburb . ' ' . $this->state . ' ' . $this->postcode;
    }

    // Required for SMS system
    public function smsMessages()
    {
        return $this->morphMany(\App\Models\SmsMessage::class, 'messageable');
    }

    public function accountSubscription()
	{
		return $this->belongsTo(\App\Models\AccountSubscription::class, 'subscription_usn', 'usn');
    }

    public function serviceOrder()
	{
		return $this->belongsTo(\App\Models\ServiceOrder::class, 'service_order_id', 'id');
    }

    public function product()
	{
		return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
}
