<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmVoIPPhoneOrderMail extends Mailable
{
    use SerializesModels;

    public $order;
    public $voiceServiceOrder;
    public $company;
    public $billingFullAddress;
    public $contractLength;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($serviceOrder, $voiceServiceOrder, $company)
    {
        $this->order = $serviceOrder;
        $this->voiceServiceOrder = $voiceServiceOrder;
        $this->company = $company;
        $this->contractLength = 1;

        $this->billingFullAddress = null;

        foreach ($serviceOrder->addresses as $address) {
            if ($address->address_type !== 'Delivery') {
                $this->billingFullAddress = $address->full_address;
            }
            if ($address->address_type === 'Billing') {
                break;
            }
        }
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
            ->view('emails.confirm-voip-phone-order')->subject('Metwide VoIP Phone order confirmation');
    }
}
