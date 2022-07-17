<?php

namespace App\Traits;

use App\Models\Address;

trait CreateOrderAddressTrait
{
    public function createOrderAddress($serviceOrder, $request)
    {

        if ($request->input('addressMetadata') !== null) {
            $isBusiness = $request->input('accountType') === "Business" ? true : false;
            $addressType = $isBusiness ? 'Business' : 'Home';

            $homeBusinessAddress = $this->createAddress($serviceOrder, $addressType, $request->input('addressMetadata'));
        }

        if ($request->input('homeAddressMetadata') !== null) {
            $isBusiness = $request->input('accountType') === "Business" ? true : false;
            $addressType = $isBusiness ? 'Business' : 'Home';

            $homeBusinessAddress = $this->createAddress($serviceOrder, $addressType, $request->input('homeAddressMetadata'));
        }

        if ($request->input('serviceAddressMetadata') !== null) {
            $isBusiness = $request->input('accountType') === "Business" ? true : false;
            $addressType = $isBusiness ? 'Business' : 'Home';

            $homeBusinessAddress = $this->createAddress($serviceOrder, $addressType, $request->input('serviceAddressMetadata'));
        }

        if ($request->input('deliveryAddressMetadata') !== null) {
            $addressType = 'Delivery';
            $homeBusinessAddress = $this->createAddress($serviceOrder, $addressType, $request->input('deliveryAddressMetadata'));
        }

        if ($request->input('billingAddressMetadata') !== null) {
            $addressType = 'Billing';
            $homeBusinessAddress = $this->createAddress($serviceOrder, $addressType, $request->input('billingAddressMetadata'));
        }

        if ($request->input('site') === 'My Account') {
            $addressType = 'Delivery';
            $address = $this->createAddressMARequest($serviceOrder, $addressType, $request);
        }

        return true;
    }

    private function createAddress($serviceOrder, $addressType, $addressMetadata)
    {

        $streetAddress = $addressMetadata['address_line_1'];

        $streetAddress = $addressMetadata['address_line_2'] ? $streetAddress . ', ' . $addressMetadata['address_line_2'] : $streetAddress;

        $localityAddress = implode(' ', [$addressMetadata['locality_name'], $addressMetadata['state_territory'], $addressMetadata['postcode']]);

        if ($addressType !== 'Billing') {
            $serviceOrder->delivery_street_address = $streetAddress;
            $serviceOrder->delivery_locality_address = $localityAddress;
            $serviceOrder->save();
        }

        $address = Address::create([
            'service_order_id' => $serviceOrder->id,
            'address_type' => $addressType,
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
            'street_number_2' =>  $addressMetadata['street_number_2'] ?? null,
            'street_number_suffix_2' => null,
            'street_name' => $addressMetadata['street_name'] ?? null,
            'street_type' => $addressMetadata['street_type'] ?? null,
            'street_type_suffix' => $addressMetadata['street_suffix'] ?? null,
            'suburb' => $addressMetadata['locality_name'] ?? null,
            'state' => $addressMetadata['state_territory'] ?? null,
            'postcode' => $addressMetadata['postcode'] ?? null,
        ]);
    }

    /* Used when the request is coming from the My Account */
    private function createAddressMARequest($serviceOrder, $addressType, $request)
    {

        $streetAddress = $request->input('streetAddress');

        $suburb = $request->input('suburb');

        $state = $request->input('state');

        $postcode = $request->input('postcode');

        $localityAddress = implode(' ', [$suburb, $state, $postcode]);

        $fullAddress = implode(', ', [$streetAddress, $localityAddress]);

        

        $address = Address::create([
            'service_order_id' => $serviceOrder->id,
            'address_type' => $addressType,
            'full_address' => $fullAddress,
            'street_address' => $streetAddress,
            'locality_address' => $localityAddress,
            'address_line_1' => $streetAddress,
            'address_line_2' => null,
            'plan_number' => null,
            'site_name' =>  null,
            'lot_number' =>  null,
            'level_type' => null,
            'level_number' => null,
            'unit_type' => null,
            'unit_number' => null,
            'street_number' => null,
            'street_number_suffix' => null,
            'street_number_2' =>  null,
            'street_number_suffix_2' => null,
            'street_name' => null,
            'street_type' => null,
            'street_type_suffix' =>  null,
            'suburb' => $suburb ?? null,
            'state' => $state ?? null,
            'postcode' => $postcode ?? null,
        ]);
    }

    private function createBillingAddress($serviceOrder, $request)
    {

        $streetAddress = $addressMetadata['address_line_1'];

        $streetAddress = $addressMetadata['address_line_2'] ? $streetAddress . ', ' . $addressMetadata['address_line_2'] : $streetAddress;

        $localityAddress = implode(' ', [$addressMetadata['locality_name'], $addressMetadata['state_territory'], $addressMetadata['postcode']]);

        if ($addressType !== 'Billing') {
            $serviceOrder->delivery_street_address = $streetAddress;
            $serviceOrder->delivery_locality_address = $localityAddress;
            $serviceOrder->save();
        }

        $address = Address::create([
            'service_order_id' => $serviceOrder->id,
            'address_type' => $addressType,
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
            'street_number_2' =>  $addressMetadata['street_number_2'] ?? null,
            'street_number_suffix_2' => null,
            'street_name' => $addressMetadata['street_name'] ?? null,
            'street_type' => $addressMetadata['street_type'] ?? null,
            'street_type_suffix' => $addressMetadata['street_suffix'] ?? null,
            'suburb' => $addressMetadata['locality_name'] ?? null,
            'state' => $addressMetadata['state_territory'] ?? null,
            'postcode' => $addressMetadata['postcode'] ?? null,
        ]);
    }
}
