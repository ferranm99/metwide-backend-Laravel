<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'
    ];

    protected $fillable = [
        'uid',
        'company',
        'ucn',
        'name',
        'is_company',
        'company_name',
        'trading_name',
        'abn',
        'contact_title',
        'contact_family',
        'contact_given',
        'position',
        'home_phone',
        'mobile_phone',
        'work_phone',
        'email',
        'dob',
        'full_address',
        'street_address',
        'street_address_po_box',
        'street_address_lot_number',
        'street_address_building_name',
        'street_address_postal_delivery_type',
        'street_address_level_number',
        'street_address_unit_type',
        'street_address_unit_number',
        'street_address_street_number',
        'street_address_street_name',
        'street_address_street_type',
        'street_address_street_type_suffix',
        'street_address_suburb',
        'street_address_state',
        'street_address_postcode',
        'street_address_country',
        'billing_info_same',
        'bill_contact_first_name',
        'bill_contact_last_name',
        'bill_contact_position',
        'bill_contact_number',
        'bill_contact_email',
        'bill_full_address',
        'billing_address',
        'bill_address_po_box',
        'bill_address_lot_number',
        'bill_address_building_name',
        'bill_address_level_number',
        'bill_address_postal_delivery_type',
        'bill_address_unit_number',
        'bill_address_unit_type',
        'bill_address_street_number',
        'bill_address_street_name',
        'bill_address_street_type',
        'bill_address_street_ytype_suffix',
        'bill_address_suburb',
        'bill_address_state',
        'bill_address_postcode',
        'bill_address_country',
        'account_balance',
        'current_balance',
        'thirty_days_balance',
        'sixty_days_balance',
        'ninety_days_balance',
        'last_invoice_date',
        'last_invoice_due_date',
        'unpaid_invoices',
        'payment_type',
        'auto_payment_option',
        'from_account_terms',
        'account_type',
        'account_terms',
        'updated',
        'exception',
        'subscriptions_count',
        'status',
        'created_date',
        'order_number',
        'credit_card_number',
        'expiry',
        'cc_token',
        'password',
        'two_factor_confirmed',
        'is_reseller',
        'reseller_ucn'
    ];

    protected $casts = [
        'last_invoice_date' => 'date',
        'last_invoice_due_date' => 'date',
        'dob' => 'date',
        'two_factor_confirmed' => 'boolean'
    ];

    protected $appends = [
        'two_factor_enabled',
    ];

    public function getFullNameAttribute()
    {

        $fullName = ucfirst($this->contact_title) . ' ' . ucfirst($this->contact_given) . ' ' . ucfirst($this->contact_family);

        return trim($fullName);
    }

    public function getBillingFullNameAttribute()
    {

        $billingFullName = ucfirst($this->bill_contact_first_name) . ' ' . ucfirst($this->bill_contact_last_name);

        return trim($billingFullName);
    }

    public function getTwoFactorEnabledAttribute()
    {
        return !is_null($this->two_factor_secret);
    }

    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed = true;
            $this->save();

            return true;
        }

        return false;
    }

    public function updateTwoFactorConfirmed($value)
    {
        $this->two_factor_confirmed = $value;
        $this->save();

        return true;
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\AccountSubscription::class, 'account_ucn', 'ucn');
    }

    public function reseller()
    {
        return $this->belongsTo(\App\Models\Account::class, 'reseller_ucn', 'ucn');
    }

    public function resellerCustomers()
    {
        return $this->hasMany(\App\Models\Account::class, 'reseller_ucn', 'ucn');
    }

    public function accountUsers()
    {
        return $this->hasMany(\App\Models\AccountUser::class, 'account_ucn', 'ucn');
    }
}
