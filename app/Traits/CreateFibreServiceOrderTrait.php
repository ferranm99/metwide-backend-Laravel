<?php

namespace App\Traits;

use App\Models\BroadbandServiceOrder;
use App\Models\DataPlan;
use App\Models\ServiceQualification;
use App\Helpers\GeneratePassword;
use SebastianBergmann\Type\NullType;

trait CreateFibreServiceOrderTrait
{
    public function createFibreServiceOrder($serviceOrder, $request)
    {

        $phoneType = $request->input('phoneType') ?? null;

        $contactNumber = $request->input('phoneNumber') ?? null;

        $mobileNumber = $phoneType === 'Mobile' ? $contactNumber : null;

        $speedTier = $request->input('speed') ?? null;
        $monthlyData = $request->input('monthlyData') ?? null;

        $monthlyPlanFee = $request->input('monthlyPlanFee') ?? 0;

        $requireStaticIp = $request->input('requireStaticIp') ?? false;
        $staticIpMonthlyFee = $requireStaticIp ? $request->input('staticIpMonthlyFee') : 0;

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $broadbandServiceOrder = BroadbandServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'data_plan_id' => $this->getDataPlan($speedTier, $monthlyData),
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $monthlyPlanFee,
            'service_number' => $request->input('FNN') ?? null,
            'connection_type' => $request->input('serviceType') ?? null,
            'require_static_ip' => $requireStaticIp,
            'static_ip_monthly_fee' => $staticIpMonthlyFee,
            'min_monthly_cost' => $monthlyPlanFee + $staticIpMonthlyFee,
            'qualification_id' => null,
            'transfer_service' => $request->input('transferThisNBNServiceToUs') === 'yes' ? true : false,
            'connect_new_service' => $request->input('connectNewService') === 'yes' ? true : false,
            'require_new_cpi' => null,
            'new_cpi_charge' => $request->input('newLineConnectionCharge') ?? 0,
            'nbn_cpe_plan_id' => null,
            'data_port_number' => null,
            'ntdid' => null,
            'copper_pair_id' => null,
            'order_tx_id' => null,
            'username' => $this->getBroadbaneUsername($serviceOrderReference),
            'password' => GeneratePassword::value(12),
            'location_id' => $request->input('directoryId') ?? null,
            'full_address' => $request->input('addressMetadata.full_address') ?? null,
            'address_line_1' => $request->input('addressMetadata.address_line_1') ?? null,
            'address_line_2' => $request->input('addressMetadata.address_line_2') ?? null,
            'plan_number' => null,
            'site_name' => $request->input('addressMetadata.site_name') ?? null,
            'lot_number' => $request->input('addressMetadata.lot_identifier') ?? null,
            'level_type' => $request->input('addressMetadata.level_type') ?? null,
            'level_number' => $request->input('addressMetadata.level_number') ?? null,
            'unit_type' => $request->input('addressMetadata.unit_type') ?? null,
            'unit_number' => $request->input('addressMetadata.unit_identifier') ?? null,
            'street_number' => $request->input('addressMetadata.street_number_1') ?? null,
            'street_number_suffix' => null,
            'street_number_2' => $request->input('addressMetadata.street_number_2') ?? null,
            'street_number_suffix_2' => null,
            'street_name' => $request->input('addressMetadata.street_name') ?? null,
            'street_type' => $request->input('addressMetadata.street_type') ?? null,
            'street_type_suffix' => $request->input('addressMetadata.street_suffix') ?? null,
            'suburb' => $request->input('addressMetadata.locality_name') ?? null,
            'state' => $request->input('addressMetadata.state_territory') ?? null,
            'postcode' => $request->input('addressMetadata.postcode') ?? null,
            'service_contact_first_name' => $request->input('firstName') ?? null,
            'service_contact_last_name' => $request->input('lastName') ?? null,
            'service_contact_phone_number' => $contactNumber,
            'service_contact_mobile_number' => $mobileNumber,
            'service_contact_email' => $request->input('email') ?? null,
            'draft_order' => false,

        ]);

        return $broadbandServiceOrder;
    }

    private function getDataPlan($speed, $dataAllowance)
    {
        if ($dataAllowance != 'Unlimited') {
            $data = explode(" ", $dataAllowance);
            $dataAllowance = $data[0];
        }

        $dataPlan = DataPlan::where('service_category_id', 1)->where('download_speed', $speed)->where('data_allowance', $dataAllowance)->first();

        return $dataPlan->id ?? null;
    }

    private function getBroadbaneUsername($orderReferenceNumber)
    {

        $username = str_replace('-', '', strtolower($orderReferenceNumber)) . '@nbn.alphacall.com.au';

        return $username;
    }
}
