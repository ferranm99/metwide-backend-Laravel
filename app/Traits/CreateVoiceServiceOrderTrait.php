<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\BroadbandServiceOrder;
use App\Models\DataPlan;
use App\Models\VoiceServiceOrder;
use App\Helpers\GeneratePassword;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Type\NullType;

trait CreateVoiceServiceOrderTrait
{
    public function createVoiceServiceOrder($serviceOrder, $request, $referenceIndex)
    {

        $activePhoneNumber = null;
        $monthlyPlanFee = 0;
        $addressMetadata = null;

        if (Str::contains($request->input('serviceName'), 'VoIP')) {
            $activePhoneNumber = $request->input('activePhoneNumber') ?? null;
            $monthlyPlanFee = $request->input('monthlyPlanFee') ?? 0;
            $addressMetadata = $request->input('serviceAddressMetadata') ?? [];
        } elseif (!Str::contains($request->input('serviceName'), 'VoIP')) {
            $activePhoneNumber = $request->input('FNN') ?? null;
            $monthlyPlanFee = $request->input('alphaPhoneVoIPPrice') ?? 0;
            $addressMetadata = $request->input('addressMetadata') ?? [];
        }

        $streetAddress = $this->parseStreetAddress($addressMetadata);

        $localityAddress = $this->parseLocalityAddress($addressMetadata);

        $phoneType = $request->input('phoneType') ?? null;

        $contactNumber = $request->input('phoneNumber') ?? null;

        $mobileNumber = $phoneType === 'Mobile' ? $contactNumber : null;

        $serviceOrderReference = $serviceOrder->order_reference . '-' . $referenceIndex;

        $voipPhonePlan = $request->input('voipPhonePlan');

        $internationalCallPack = $request->input('internationalCallPack') ?? false;

        $monthlyCallPackFee = $internationalCallPack === true ? $request->input('internationalCallPackCharge') : 0;

        $voiceServiceOrder = VoiceServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'voice_plan_id' => $this->getVoicePlanId($voipPhonePlan),
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $monthlyPlanFee,
            'phone_number_min' => $activePhoneNumber,
            'phone_number_max' => $activePhoneNumber,
            'is_international_call_pack' => $internationalCallPack,
            'monthly_call_pack_fee' => $monthlyCallPackFee,
            'min_monthly_cost' => $monthlyPlanFee + $monthlyCallPackFee,
            'is_port_number' => $request->input('transferPhoneNumber') === 'yes' ? true : false,
            'current_provider' => $request->input('currentServiceProvider') ?? null,
            'current_account_number' => $request->input('currentPhoneAccountNumber') ?? nulL,
            'location_id' => $request->input('directoryId') ?? null,
            'telstra_id' => null,
            'full_address' => $addressMetadata['full_address'] ?? null,
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
            'state' => $addressMetadata['state_territory'] ?? null,
            'postcode' => $addressMetadata['postcode'] ?? null,
            'service_contact_first_name' => $request->input('firstName') ?? null,
            'service_contact_last_name' => $request->input('lastName') ?? null,
            'service_contact_phone_number' => $contactNumber,
            'service_contact_mobile_number' => $mobileNumber,
            'service_contact_email' => $request->input('email') ?? null,
            'draft_order' => false,
            'plan_name' => $request->input('serviceName') ?? null

        ]);

        return $voiceServiceOrder;
    }

    public function createVoiceServiceOrderPortal($serviceOrder, $request)
    {

        $voiceServiceOrders = [];

        if ($request->input('voipNewOrTransfer') === 'portPhoneNumber') {
            $phoneNumbers = $request->input('phoneNumbers');

            foreach ($phoneNumbers as $key => $phoneNumber) {
                $voiceServiceOrder = $this->createDBVoiceServiceOrder($serviceOrder, $request, $phoneNumber['number']);
                array_push($voiceServiceOrders, $voiceServiceOrder);
            }
        } else {
            $voiceServiceOrder = $this->createDBVoiceServiceOrder($serviceOrder, $request, null);
            array_push($voiceServiceOrders, $voiceServiceOrder);
        }

        return $voiceServiceOrders;
    }

    private function getVoicePlanId($voipPhonePlan)
    {
        if ($voipPhonePlan === 'payg') {
            return 6;
        } elseif ($voipPhonePlan === 'unlimited') {
            return 5;
        }

        return null;
    }

    private function getVoicePlan($voipPhonePlan)
    {
        if ($voipPhonePlan === 'payg') {
            return 'PAYG Calls';
        } elseif ($voipPhonePlan === 'unlimited') {
            return 'Unlimited Calls';
        }

        return null;
    }

    private function parseStreetAddress($addressMetadata)
    {
        $streetAddress = $addressMetadata['address_line_1'] && null;
        $streetAddress = $addressMetadata['address_line_2'] ? $streetAddress . ', ' . $addressMetadata['address_line_2'] : $streetAddress;

        return $streetAddress;
    }

    private function parseStreetAddressPortal($address)
    {

        $unit = $address['unitNumber'] .  $address['unitNumberSuffix'];

        Log::debug($address);
        $streetNumber =  $address['streetNumber'] . $address['streetNumberSuffix'];
        $streetNumber2nd =  $address['streetNumber2nd'] . $address['streetNumber2ndSuffix'];

        $streetNumber = $streetNumber2nd ? $streetNumber . '-' . $streetNumber2nd : $streetNumber;

        $street = implode(' ', [$address['streetName'], $address['streetType'], $address['streetSuffix']]);

        $unit = $unit ? $unit . ',' : '';

        $streetAddress = implode(' ', [$unit,  $streetNumber, $street]);

        return $streetAddress;
    }

    private function parseLocalityAddress($addressMetadata)
    {
        $localityAddress = implode(' ', [$addressMetadata['locality_name'], $addressMetadata['state_territory'], $addressMetadata['postcode']]);

        return $localityAddress;
    }

    private function createDBVoiceServiceOrder($serviceOrder, $request, $phoneNumber)
    {

        $activePhoneNumber = null;
        $monthlyPlanFee = 0;
        $addressMetadata = null;

        $voipServiceAddress = $request->input('voipServiceAddress');

        $streetAddress = $this->parseStreetAddressPortal($voipServiceAddress);

        $localityAddress = implode(' ', [$voipServiceAddress['suburb'], $voipServiceAddress['state'], $voipServiceAddress['postcode']]);

        $contactNumber = $request->input('siteContactPhoneNumber') ? $request->input('siteContactPhoneNumber') : $request->input('siteContactMobileNumber');

        $mobileNumber = $request->input('siteContactMobileNumber');

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $voipPhonePlan = $request->input('voipPhonePlan');

        $internationalCallPack = $request->input('internationalCallPack') ?? false;

        $monthlyCallPackFee = $internationalCallPack === true ? $request->input('internationalCallPackCharge') : 0;

        $voiceServiceOrder = VoiceServiceOrder::create([
            'service_order_id' => $serviceOrder->id,
            'voice_plan_id' => $this->getVoicePlanId($voipPhonePlan),
            'subscription_usn' => null,
            'service_order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
            'provisioning_sub_status' => null,
            'billing_status' => null,
            'monthly_plan_fee' => $monthlyPlanFee,
            'phone_number_min' => $phoneNumber ?? null,
            'phone_number_max' => $phoneNumber ?? null,
            'is_international_call_pack' => $internationalCallPack,
            'monthly_call_pack_fee' => $monthlyCallPackFee,
            'min_monthly_cost' => $monthlyPlanFee + $monthlyCallPackFee,
            'is_port_number' => $request->input('voipNewOrTransfer') === 'portPhoneNumber' ? true : false,
            'current_provider' => $request->input('currentServiceProvider') ?? null,
            'current_account_number' => $request->input('currentPhoneAccountNumber') ?? nulL,
            'location_id' => $request->input('directoryId') ?? null,
            'telstra_id' => $request->input('telstraID') ?? null,
            'full_address' => $voipServiceAddress['fullAddress'] ?? null,
            'street_address' => $streetAddress,
            'locality_address' => $localityAddress,
            'address_line_1' => $streetAddress,
            'address_line_2' => null,
            'plan_number' => null,
            'site_name' => $voipServiceAddress['siteName'] ?? null,
            'lot_number' => $voipServiceAddress['lotIdentifier'] ?? null,
            'level_type' => $voipServiceAddress['levelType'] ?? null,
            'level_number' => $voipServiceAddress['levelNumber'] ?? null,
            'unit_type' => $voipServiceAddress['unitType'] ?? null,
            'unit_number' => $voipServiceAddress['unitNumber'] ?? null,
            'street_number' => $voipServiceAddress['streetNumber'] ?? null,
            'street_number_suffix' => $voipServiceAddress['streetNumberSuffix'] ?? null,
            'street_number_2' => $voipServiceAddress['streetNumber2nd'] ?? null,
            'street_number_suffix_2' => $voipServiceAddress['streetNumber2ndSuffix'] ?? null,
            'street_name' => $voipServiceAddress['streetName'] ?? null,
            'street_type' => $voipServiceAddress['streetType'] ?? null,
            'street_type_suffix' => $voipServiceAddress['streetSuffix'] ?? null,
            'suburb' => $voipServiceAddress['suburb'] ?? null,
            'state' => $voipServiceAddress['state'] ?? null,
            'postcode' => $voipServiceAddress['postcode'] ?? null,
            'service_contact_first_name' => $request->input('siteContactFirstName') ?? null,
            'service_contact_last_name' => $request->input('siteContactLastName') ?? null,
            'service_contact_phone_number' => $contactNumber,
            'service_contact_mobile_number' => $mobileNumber,
            'service_contact_email' => $request->input('siteContactEmail') ?? null,
            'draft_order' => false,
            'plan_name' => $request->input('serviceName') ?? null

        ]);
    }
}
