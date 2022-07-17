<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\MobilePlan;
use App\Models\MobileServiceOrder;
use SebastianBergmann\Type\NullType;

trait CreateMobileServiceOrderTrait
{
    public function createMobileServiceOrder($serviceOrder, $request)
    {

        $phoneType = $request->input('phoneType') ?? null;

        $contactNumber = $request->input('phoneNumber') ?? null;

        $mobileNumber = $phoneType === 'Mobile' ? $contactNumber : null;

        $monthlyPlanFee = $request->input('monthlyPlanFee') ?? 0;

        $monthlyData = $request->input('monthlyData') ?? null;
        $monthlyData = preg_split('#(?<=\d)(?=[a-z])#i', $monthlyData);
        $monthlyDataUnit = $monthlyData[1];
        $monthlyData = $monthlyData[0];

        $mobilePlan = null;
        if (Str::contains($request->input('serviceName'), 'AlphaGo')) {
            $mobilePlan = $this->getMobileBroadbandPlan($monthlyData);
        } elseif (Str::contains($request->input('serviceName'), 'AlphaSim')) {
            $mobilePlan = $this->getMobilePlan($monthlyData);
        }

        if (Str::contains($request->input('serviceName'), 'AlphaGo')) {
            $mobileBroadband = true;
        }

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $dobOnAccount = null;
        if ($request->input('birthYearOnAccount') !== null) {
            $dobOnAccount = $request->input('birthYearOnAccount') . '-' . $request->input('birthMonthOnAccount') . '-' . $request->input('birthDayOnAccount');
        $dobOnAccount = date('Y-m-d', strtotime($dobOnAccount));
        }
        $dobOnAccount = $request->input('birthYearOnAccount') . '-' . $request->input('birthMonthOnAccount') . '-' . $request->input('birthDayOnAccount');
        $dobOnAccount = date('Y-m-d', strtotime($dobOnAccount));

        $mobileServiceOrder = MobileServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'mobile_plan_id' => $mobilePlan,
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $request->input('monthlyPlanFee') ?? null,
            'min_monthly_cost' => $request->input('monthlyPlanFee') ?? null,
            'activation_fee' => $request->input('activationFee') ?? 0,
            'mobile_number' => $request->input('yourPhoneNumber') ?? null,
            'is_port_number' => $request->input('keepCurrentNumber') === 'yes' ? true : false,
            'current_provider' => $request->input('currentProvider') ?? null,
            'current_account_number' => $request->input('currentAccountNumber') ?? null,
            'current_mobile_plan' => $request->input('currentPlan') ?? null,
            'dob_on_current_account' => $dobOnAccount,
            'sim_card_no' => null,
            'sim_delivery_letter' => null,
            'sim_activation_sent' => null,
            'service_contact_first_name' => $request->input('firstName') ?? null,
            'service_contact_last_name' => $request->input('lastName') ?? null,
            'service_contact_phone_number' => $contactNumber,
            'service_contact_mobile_number' => $mobileNumber,
            'service_contact_email' => $request->input('email') ?? null,
            'draft_order' => false,
            'plan_name' => $request->input('serviceName') ?? null

        ]);

        return $mobileServiceOrder;
    }

    private function getMobileBroadbandPlan($dataAllowance)
    {

        $mobilePlan = MobilePlan::where('service_category_id', 5)->where('data_allowance', $dataAllowance)->first();

        return $mobilePlan->id ?? null;
    }

    private function getMobilePlan($dataAllowance)
    {

        $mobilePlan = MobilePlan::where('service_category_id', 4)->where('data_allowance', $dataAllowance)->first();

        return $mobilePlan->id ?? null;

    }
}
