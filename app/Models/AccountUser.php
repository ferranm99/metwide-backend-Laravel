<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class AccountUser extends Authenticatable
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
        'account_ucn',
        'first_name',
        'last_name',
        'position',
        'account_owner',
        'email',
        'phone_number',
        'mobile_number',
        'password',
        'two_factor_secret',
       // 'two_factor_recovery_codes',
       // 'two_factor_confirmed',
    ];

    protected $casts = [
        'two_factor_confirmed' => 'boolean',
        'account_owner' => 'boolean'
    ];

    protected $appends = [
        'two_factor_enabled',
    ];
    
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_ucn', 'ucn');
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
}
