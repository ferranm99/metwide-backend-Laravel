<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptServiceQualification;

use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;

use App\Http\Controllers\AAPTFrontierController;

use App\Services\AAPTFrontier\Actions\GenerateAaptTestOutcome;
use App\Services\AAPTFrontier\Actions\GenerateAaptAccessQualification;
use App\Services\AAPTFrontier\Actions\GenerateNbnNetworkTerminationDevice;
use App\Services\AAPTFrontier\Actions\GenerateAaptNbnCopperPair;

class QualifyAAPTService
{

    public function execute($aaptServiceQualification, $serviceProvider, $productType)
    {

        $aaptFrontierController = new AAPTFrontierController();

        $aaptLocationID = null;
        $telstraLocationID = null;

        if ($productType === 'e-Line') {

            $endCSN = $aaptServiceQualification->service_fnn ?? null;
            $aaptLocationID = $aaptServiceQualification->building_id ?? null;
            $telstraLocationID = $aaptServiceQualification->telstra_id ?? null;

            if (isset($serviceProvider)) {

                if ($serviceProvider === 'AAPT') {
                    $aaptLocationID = $aaptServiceQualification->location_id;
                } elseif ($serviceProvider === 'Telstra') {
                    $telstraLocationID = $aaptServiceQualification->location_id;
                }
            }

            $eLineType = $aaptServiceQualification->e_line_type;
            $ethernetAccessType = $aaptServiceQualification->ethernet_access_type;


            $sqResponse = $aaptFrontierController->qualifyELine($endCSN, $aaptLocationID, $telstraLocationID, $eLineType, $ethernetAccessType);
            Debugbar::info($sqResponse);
        } elseif ($productType === 'e-Lan') {

            $endCSN = $aaptServiceQualification->service_fnn;
            $ethernetQosType = $aaptServiceQualification->ethernet_qos_type;
            $ethernetAccessType = $aaptServiceQualification->ethernet_access_type;

            $sqResponse = $aaptFrontierController->qualifyELan($endCSN, $aaptLocationID, $telstraLocationID, $ethernetQosType, $ethernetAccessType);
        } elseif ($productType === 'NWB') {
            $sqResponse = $aaptFrontierController->qualifyNWB($aaptServiceQualification->location_id);
            $aaptServiceQualification->service_provider = 'NBN';
        } elseif ($productType === 'Fast Fibre') {
            $sqResponse = $aaptFrontierController->qualifyFastFibre(null, $aaptServiceQualification->location_id);
            $aaptServiceQualification->service_provider = 'NBN';
        }
        //  $sqResponse = $aaptFrontierController->qualifyLocationId($aaptServiceQualification->location_id);

        $aaptServiceQualification->latitude = $sqResponse->siteDetails->gpsLocation->latitude ?? null;
        $aaptServiceQualification->longitude = $sqResponse->siteDetails->gpsLocation->longitude ?? null;

        $aaptServiceQualification->qualification_id = $sqResponse->qualificationID ?? null;
        $aaptServiceQualification->exchange_code = $sqResponse->siteDetails->exchangeCode ?? null;
        $aaptServiceQualification->exchange_service_area = $sqResponse->siteDetails->exchangeServiceArea ?? null;
        $aaptServiceQualification->distance_to_exchange = $sqResponse->siteDetails->distanceToExchange ?? null;
        $aaptServiceQualification->nbn_serviceability_class = $sqResponse->siteDetails->nbnServiceabilityClass ?? null;
        $aaptServiceQualification->dsl_codes_on_line = $sqResponse->siteDetails->dslCodesOnLine ?? null;

        $aaptSQID = $aaptServiceQualification->id;

        Debugbar::info($aaptSQID);
      //  throw new Exception('foo');

        $longAddress = $this->setLongAddress($aaptServiceQualification);

        if ($longAddress === '') {
            $longAddress = $this->setAddressDetails($aaptServiceQualification, $sqResponse);
        }

        foreach ($sqResponse->accessQualificationList as $accessQualification) {

            $aaptAccessQualification = GenerateAaptAccessQualification::execute($aaptSQID, $accessQualification);

            $accessQualID = $aaptAccessQualification->id;

            $testOutcomes = $accessQualification->testOutcomes ?? null;

            if (isset($testOutcomes)) {
                if (is_array($testOutcomes)) {
                    foreach ($testOutcomes as $testOutcome) {
                        GenerateAaptTestOutcome::execute($accessQualID, $testOutcome);
                    }
                } else {
                    GenerateAaptTestOutcome::execute($accessQualID, $testOutcomes);
                }
            }

            if (isset($accessQualification->nbnCopperPairList)) {

                $nbnCopperPairList = $accessQualification->nbnCopperPairList->nbnCopperPairList ?? null;

                $nbnCopperPairList = is_array($nbnCopperPairList) ? $nbnCopperPairList : [$nbnCopperPairList];

                foreach ($nbnCopperPairList as $nbnCopperPair) {
                    GenerateAaptNbnCopperPair::execute($accessQualID, $nbnCopperPair);
                }
            }


            if (isset($accessQualification->nbnNetworkTerminationDeviceList)) {
                $nbnNetworkTerminationDevices = $accessQualification->nbnNetworkTerminationDeviceList->nbnNetworkTerminationDevice ?? null;

                $nbnNetworkTerminationDevices = is_array($nbnNetworkTerminationDevices) ? $nbnNetworkTerminationDevices : [$nbnNetworkTerminationDevices];

                foreach ($nbnNetworkTerminationDevices as $nbnNetworkTerminationDevice) {
                    GenerateNbnNetworkTerminationDevice::execute($accessQualID, $nbnNetworkTerminationDevice);
                }
            }
        }
        //  throw new Exception('foo');
        $aaptServiceQualification->product_type = $productType;
        $aaptServiceQualification->aapt_id = $aaptLocationID;
        $aaptServiceQualification->telstra_id = $telstraLocationID;

        $aaptServiceQualification->save();

        return $aaptServiceQualification;
    }

    private function setLongAddress($serviceQualification)
    {

        $lotNumber = $serviceQualification->lot_number ?? '';
        $lotNumber = $lotNumber === '' ? '' : 'Lot ' . $lotNumber;

        $streetNumber = $serviceQualification->street_number ?? '';
        $streetNumberSuffix =  $serviceQualification->street_number_suffix ?? '';
        $streetNumber = $streetNumber . $streetNumberSuffix;

        $streetType = $serviceQualification->street_type  ?? '';
        $streetTypeSuffix = $serviceQualification->street_type_suffix ?? '';
        $streetType = $streetType . $streetTypeSuffix;

        $streetInformation = '';
        $streetName = $serviceQualification->street_name  ?? '';
        if ($streetName === '') {
            $streetInformation = $serviceQualification->street_address;
        }
        else {
            $streetInformation = $streetName . ' ' . $streetType;
        }

        $streetInformation = trim($streetInformation);

        $longAddress = implode(' ', array($lotNumber, $serviceQualification->unit_number  ?? '', $streetNumber, $streetInformation, $serviceQualification->suburb  ?? '', $serviceQualification->state  ?? '', $serviceQualification->postcode ?? ''));

        $longAddress = trim($longAddress);

        $serviceQualification->long_address = strtoupper($longAddress);

        $serviceQualification->save();

        return $longAddress;
    }

    private function setAddressDetails($serviceQualification, $sqResponse)
    {

        $siteAddress = $sqResponse->siteAddress ?? null;

        if ($siteAddress === null) {
            return '';
        }

        $addressInformation = $siteAddress->addressInformation ?? '';

        $streetNumber = $siteAddress->streetNumber ?? '';
        $streetNumberSuffix =  $siteAddress->streetNumberSuffix ?? '';
        $streetNumber = $streetNumber . $streetNumberSuffix;

        $streetType = $siteAddress->streetType  ?? '';
        $streetTypeSuffix = $siteAddress->streetSuffix ?? '';
        $streetType = $streetType . $streetTypeSuffix;

        $subAddressNumber = $siteAddress->subAddressNumber ?? '';
        $subAddressType = $siteAddress->subAddressType ?? '';
        $subAddress = trim($subAddressType . ' ' . $subAddressNumber);

        $longAddress = implode(' ', array($addressInformation, $subAddress, $streetNumber, $siteAddress->streetName  ?? '', $streetType, $siteAddress->suburb  ?? '', $siteAddress->state  ?? '', $siteAddress->postcode ?? ''));

        $longAddress = trim($longAddress);

        $serviceQualification->long_address = strtoupper($longAddress);

        $serviceQualification->street_address = $siteAddress->addressInformation ?? null;
        $serviceQualification->unit_number = $siteAddress->subAddressNumber ?? null;
        $serviceQualification->unit_type = $siteAddress->subAddressType ?? null;
        $serviceQualification->street_number = $siteAddress->streetNumber ?? null;
        $serviceQualification->street_number_suffix = $siteAddress->streetNumberSuffix ?? null;
        $serviceQualification->street_name = $siteAddress->streetName ?? null;
        $serviceQualification->street_type = $siteAddress->streetType ?? null;
        $serviceQualification->street_type_suffix = $siteAddress->streetTypeSuffix ?? null;
        $serviceQualification->suburb = $siteAddress->suburb ?? null;
        $serviceQualification->state = $siteAddress->state ?? null;
        $serviceQualification->postcode = $siteAddress->postcode ?? null;

        $serviceQualification->save();

        return $serviceQualification;
    }
}
