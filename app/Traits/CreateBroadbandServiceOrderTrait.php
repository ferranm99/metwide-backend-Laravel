<?php

namespace App\Traits;

use App\Models\BroadbandServiceOrder;
use App\Models\DataPlan;
use App\Models\SupportPackagePlan;
use App\Models\ServiceQualification;
use App\Helpers\GeneratePassword;
use SebastianBergmann\Type\NullType;

trait CreateBroadbandServiceOrderTrait
{
    public function createBroadbandServiceOrder($serviceOrder, $request)
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

        $serviceType = $request->input('serviceType') ?? null;

        $streetAddress = $request->input('addressMetadata.address_line_1');

        $streetAddress = $request->input('addressMetadata.address_line_2') ? $streetAddress . ', ' . $request->input('addressMetadata.address_line_2') : $streetAddress;

        $localityAddress = implode(' ', [$request->input('addressMetadata.locality_name'), $request->input('addressMetadata.state_territory'), $request->input('addressMetadata.postcode')]);

        $siteContact = $this->getSiteContactDetails($request, $contactNumber, $mobileNumber);

        $broadbandServiceOrder = BroadbandServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'data_plan_id' => $this->getBroadbandPlan($speedTier, $monthlyData),
            'support_package_plan_id' => $this->getSupportPackagePlan($request->input('supportPackage')),
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $monthlyPlanFee,
            'service_number' => $request->input('FNN') ?? null,
            'connection_type' => $serviceType,
            'require_static_ip' => $requireStaticIp,
            'static_ip_monthly_fee' => $staticIpMonthlyFee,
            'min_monthly_cost' => $monthlyPlanFee + $staticIpMonthlyFee,
            'qualification_id' => null,
            'transfer_service' => $request->input('transferBroadbandServiceToUs') === 'yes' ? true : false,
            'connect_new_service' => $request->input('connectNewService') === 'yes' ? true : false,
            'require_new_cpi' => null,
            'new_cpi_charge' => $request->input('newLineConnectionCharge') ?? 0,
            'nbn_cpe_plan_id' => null,
            'data_port_number' => null,
            'ntdid' => null,
            'copper_pair_id' => null,
            'order_tx_id' => null,
            'username' => $this->getBroadbandUsername($serviceOrderReference, $serviceType),
            'password' => GeneratePassword::value(12),
            'location_id' => $request->input('directoryId') ?? null,
            'full_address' => $request->input('addressMetadata.full_address') ?? null,
            'street_address' => $streetAddress,
            'locality_address' => $localityAddress,
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
            'service_contact_first_name' => $siteContact['siteContactFirstName'],
            'service_contact_last_name' => $siteContact['siteContactLastName'],
            'service_contact_phone_number' => $siteContact['siteContactPhoneNumber'],
            'service_contact_mobile_number' => $siteContact['siteContactMobileNumber'],
            'service_contact_email' => $siteContact['siteContactEmail'],
            'draft_order' => false,
            'activation_fee' => $request->input('activationFee') ?? 0,
            'plan_name' => $request->input('serviceName') ?? null

        ]);

        return $broadbandServiceOrder;
    }

    public function createBroadbandServiceOrderPortal($serviceOrder, $request)
    {

        $nbnServiceAddress = $request->input('nbnServiceAddress');
        // $addressMetadata = $nbnServiceAddress['addressMetadata'];
        $addressMetadata = $request->input('nbnServiceAddress.addressMetadata');

        $contactNumber = $request->input('siteContactPhoneNumber') ?? null;

        $mobileNumber = $request->input('siteContactMobileNumber') ?? null;

        $nbnDataPlan = $request->input('nbnDataPlan') ?? null;
        $speed = explode(" ", $nbnDataPlan);
        $speedTier = $speed[0];

        $monthlyData = 'Unlimited';

        $monthlyPlanFee = $request->input('monthlyPlanFee') ?? 0;

        $requireStaticIp = $request->input('requireStaticIp') ?? false;
        $staticIpMonthlyFee = $requireStaticIp ? $request->input('staticIpMonthlyFee') : 0;

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $serviceType = $request->input('serviceType') ?? null;

        $streetAddress = $addressMetadata['address_line_1'] ?? null;

        $addressLine2 = $addressMetadata['address_line_2'] ?? null;

        $streetAddress = $addressLine2 && $streetAddress ? $streetAddress . ', ' . $addressLine2 : $streetAddress;

        // $streetAddress = "";

        $localityName = $addressMetadata['locality_name'] ?? null;

        $state = $addressMetadata['state_territory'] ?? null;

        $postcode = $addressMetadata['postcode'] ?? null;

        $localityAddress =  $localityName ? implode(' ', [$localityName, $state, $postcode]) : null;

       // $localityAddress = "";

        $selectedNbnPortRecord = $request->input('selectedNbnPortRecord');
        $selectedCopperPairRecord = $request->input('selectedCopperPairRecord');

        $copperPairRecord =  $request->input('copperPairRecord') ?? null;

        $nbnPortRecord =  $request->input('nbnPortRecord') ?? null;

        $ntdid = null;
        $dataPortNumber = null;
        if ($selectedNbnPortRecord >= 0) {
            $ntdid = $nbnPortRecord[$selectedNbnPortRecord]['ntdid'];
            $dataPortNumber =  $nbnPortRecord[$selectedNbnPortRecord]['portNumber'];
        }

        $copperPairID = null;
        if ($selectedCopperPairRecord >= 0) {
            $copperPairID = $copperPairRecord[$selectedCopperPairRecord]['copperPairID'];
        }


        $broadbandServiceOrder = BroadbandServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'data_plan_id' => $this->getBroadbandPlan($speedTier, $monthlyData),
            'support_package_plan_id' => $this->getSupportPackagePlan($request->input('supportPackage')),
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $monthlyPlanFee,
            'service_number' => $request->input('FNN') ?? null,
            'connection_type' => $serviceType,
            'require_static_ip' => $requireStaticIp,
            'static_ip_monthly_fee' => $staticIpMonthlyFee,
            'min_monthly_cost' => $monthlyPlanFee + $staticIpMonthlyFee,
            'qualification_id' => null,
            'transfer_service' => $request->input('transferBroadbandServiceToUs') === 'yes' ? true : false,
            'connect_new_service' => $request->input('connectNewService') === 'yes' ? true : false,
            'require_new_cpi' => null,
            'new_cpi_charge' => $request->input('newLineConnectionCharge') ?? 0,
            'nbn_cpe_plan_id' => null,
            'data_port_number' => $dataPortNumber,
            'ntdid' => $ntdid,
            'copper_pair_id' => $copperPairID,
            'order_tx_id' => null,
            'username' => $this->getBroadbandUsername($serviceOrderReference, $serviceType),
            'password' => GeneratePassword::value(12),
            'location_id' => $request->input('locationID') ?? null,
            'full_address' => $request->input('address') ?? null,
            'street_address' => $streetAddress,
            'locality_address' => $localityAddress,
            'address_line_1' => $addressMetadata['address_line_1'] ?? null,
            'address_line_2' => $addressMetadata['address_line_2'] ?? null,
            'plan_number' => null,
            'site_name' => $addressMetadata['site_name'] ?? null,
            'lot_number' => $addressMetadata['lot_identifier'] ?? null,
            'level_type' => $addressMetadata['level_type'] ?? null,
            'level_number' => $addressMetadata['level_number'] ?? null,
            'unit_type' => $addressMetadata['unit_type'] ?? null,
            'unit_number' => $addressMetadata['unit_identifier'] ?? null,
            'street_number' => $addressMetadata['street_number_1'] ?? null,
            'street_number_suffix' => null,
            'street_number_2' => $addressMetadata['street_number_2'] ?? null,
            'street_number_suffix_2' => null,
            'street_name' => $addressMetadata['street_name'] ?? null,
            'street_type' => $addressMetadata['street_type'] ?? null,
            'street_type_suffix' => $addressMetadata['street_suffix'] ?? null,
            'suburb' => $addressMetadata['locality_name'] ?? null,
            'state' => $state,
            'postcode' => $postcode,
            'service_contact_first_name' => $request->input('siteContactFirstName') ?? null,
            'service_contact_last_name' => $request->input('siteContactLastName') ?? null,
            'service_contact_phone_number' => $request->input('siteContactPhoneNumber') ?? null,
            'service_contact_mobile_number' => $request->input('siteContactMobileNumber') ?? null,
            'service_contact_email' => $request->input('siteContactEmail') ?? null,
            'draft_order' => false,
            'activation_fee' => $request->input('activationFee') ?? 0,
            'plan_name' => $request->input('serviceName') ?? null

        ]);

        return $broadbandServiceOrder;
    }

    private function getBroadbandPlan($speed, $dataAllowance)
    {
        if ($dataAllowance != 'Unlimited') {
            $data = explode(" ", $dataAllowance);
            $dataAllowance = $data[0];
        }

        $dataPlan = DataPlan::where('service_category_id', 7)->where('download_speed', $speed)->first();

        return $dataPlan->id ?? null;
    }

    private function getSupportPackagePlan($plan)
    {
        if (!$plan) {
            return null;
        }

        $supportPackagePlan = SupportPackagePlan::where('plan_code', $plan)->first();

        return $supportPackagePlan->id ?? null;
    }

    private function getBroadbandUsername($orderReferenceNumber, $serviceType)
    {

        $prefix = $serviceType === 'Fibre' ? 'opt' : 'nbn';

        $username = str_replace('-', '', strtolower($orderReferenceNumber)) . '@' . $prefix . '.alphacall.com.au';

        return $username;
    }

    private function getSiteContactDetails($request, $contactNumber, $mobileNumber)
    {
        $siteContact = [];

        $siteContactFirstName = $request->input('siteContactFirstName') ?? null;
        if (!$siteContactFirstName) {
            $siteContactFirstName = $request->input('firstName') ?? null;
        }
        $siteContact['siteContactFirstName'] = $siteContactFirstName;

        $siteContactLastName = $request->input('siteContactLastName') ?? null;
        if (!$siteContactLastName) {
            $siteContactLastName = $request->input('firstName') ?? null;
        }
        $siteContact['siteContactLastName'] = $siteContactLastName;

        $siteContactPhoneNumber = $request->input('siteContactPhoneNumber') ?? null;
        if (!$siteContactPhoneNumber) {
            $siteContactPhoneNumber =  $contactNumber;
        }
        $siteContact['siteContactPhoneNumber'] = $siteContactPhoneNumber;

        $siteContactMobileNumber = $request->input('siteContactMobileNumber') ?? null;
        if (!$siteContactMobileNumber) {
            $siteContactMobileNumber = $mobileNumber;
        }
        $siteContact['siteContactMobileNumber'] = $siteContactMobileNumber;

        $siteContactEmail = $request->input('siteContactEmail') ?? null;
        if (!$siteContactEmail) {
            $siteContactEmail = $request->input('email') ?? null;
        }
        $siteContact['siteContactEmail'] = $siteContactEmail;

        return $siteContact;
    }
}
