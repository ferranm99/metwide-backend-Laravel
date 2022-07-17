<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\MobilePlan;

class ConfirmMobilePhoneOrder extends Mailable
{
    use SerializesModels;

    public $order;
    public $mobileServiceOrder;
    public $company;
    public $serviceStreetAddress;
    public $serviceLocalityAddress;
    public $billingFullAddress;
    public $monthlyData;
    public $contractLength;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($serviceOrder, $mobileServiceOrder, $company)
    {
        $this->order = $serviceOrder;
        $this->mobileServiceOrder = $mobileServiceOrder;
        $this->company = $company;
        $this->contractLength = 1;

        $this->serviceStreetAddress = null;
        $this->serviceLocalityAddress = null;
        $this->billingFullAddress = null;

        foreach ($serviceOrder->addresses as $address) {
            if ($address->address_type !== 'Delivery') {
                $this->billingFullAddress = $address->full_address;
            }
            if ($address->address_type === 'Billing') {
                break;
            }
        }

        foreach ($serviceOrder->addresses as $address) {
            if ($address->address_type !== 'Delivery' && $address->address_type !== 'Billing') {
                $this->serviceStreetAddress = $address->street_address;
                $this->serviceLocalityAddress = $address->locality_address;
            }
        }

        $mobilePlan = MobilePlan::where('id', $mobileServiceOrder->mobile_plan_id)->first();

        $this->monthlyData = $mobilePlan->data_allowance . $mobilePlan->data_allowance_unit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = 'orders@' . config('services.site.domain');
        $siteName = config('services.site.name');

        return $this->from($fromEmail, $siteName)
            ->view('emails.confirm-mobile-phone-order')->subject('Mobile Phone service order confirmation');
    }
}
