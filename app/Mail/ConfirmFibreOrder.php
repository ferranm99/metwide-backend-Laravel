<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\DataPlan;
use App\Models\VoicePlan;
use App\Models\VoiceServiceOrder;
use Symfony\Component\VarDumper\Cloner\Data;

class ConfirmFibreOrder extends Mailable
{
    use SerializesModels;

    public $order;
    public $broadbandServiceOrder;
    public $voiceServiceOrder;
    public $company;
    public $billingFullAddress;
    public $speedTier;
    public $contractLength;
    public $voipPlan;
    public $voipCost;
    public $monthlyData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($serviceOrder, $broadbandServiceOrder, $voiceServiceOrder, $company)
    {
        $this->order = $serviceOrder;
        $this->broadbandServiceOrder = $broadbandServiceOrder;
        $this->voiceServiceOrder = $voiceServiceOrder;
        $this->company = $company;

        foreach ($serviceOrder->addresses as $address) {
            if ($address->address_type !== 'Delivery') {
                $this->billingFullAddress = $address->full_address;
            }
            if ($address->address_type === 'Billing') {
                break;
            }
        }

        $dataPlan = DataPlan::where('id', $broadbandServiceOrder->data_plan_id)->first();

        $this->speedTier = $dataPlan->download_speed;

        $this->monthlyData = $dataPlan->data_allowance;

        $this->monthlyData = $this->monthlyData !== 'Unlimited' ? $this->monthlyData .  $dataPlan->data_allowance_unit : $this->monthlyData;

        $this->contractLength = 1;

        $this->voipPlan = null;
        $this->voipCost = 0;
        if ($voiceServiceOrder) {
            $voicePlan = VoicePlan::where('id', $voiceServiceOrder->voice_plan_id)->first();
            $this->voipPlan = $voicePlan->description ?? null;
            $this->voipCost = $voiceServiceOrder->monthly_plan_fee ?? 0;
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
            ->view('emails.confirm-fibre-order')->subject('Fibre broadband order confirmation');
    }
}
