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

class QualifyAAPTServiceLocationId
{

    public function execute($address, $locationId, $serviceProvider, $productType)
    {
        Debugbar::info($address);
        Debugbar::info($locationId);
        Debugbar::info($serviceProvider);
        Debugbar::info($productType);

        $aaptFrontierController = new AAPTFrontierController();

        $aaptServiceQualification = new AaptServiceQualification();

        $aaptLocationID = null;
        $telstraLocationID = null;

        if ($productType === 'e-Line') {

            $endCSN = null;
            $aaptLocationID = null;
            $telstraLocationID = null;

            if ($serviceProvider === 'AAPT') {
                $aaptLocationID = $locationId;
            } elseif ($serviceProvider === 'Telstra') {
                $telstraLocationID = $locationId;
            }

            $eLineType = 'Business';
            $ethernetAccessType = 'Ethernet Single Access';
            $aaptServiceQualification->e_line_type = $eLineType;
            $aaptServiceQualification->ethernet_access_type = $ethernetAccessType;

            $response = $aaptFrontierController->qualifyELine($endCSN, $aaptLocationID, $telstraLocationID, $eLineType, $ethernetAccessType);
        } elseif ($productType === 'NWB') {
            $response = $aaptFrontierController->qualifyNWB($locationId);

            $aaptServiceQualification->service_provider = 'NBN';
        } elseif ($productType === 'Fast Fibre') {
            $response = $aaptFrontierController->qualifyFastFibre(null, $locationId);
            $aaptServiceQualification->service_provider = 'NBN';
        }

        $aaptServiceQualification->latitude = $response->siteDetails->gpsLocation->latitude ?? null;
        $aaptServiceQualification->longitude = $response->siteDetails->gpsLocation->longitude ?? null;

        $aaptServiceQualification->qualification_id = $response->qualificationID ?? null;
        $aaptServiceQualification->exchange_code = $response->siteDetails->exchangeCode ?? null;
        $aaptServiceQualification->exchange_service_area = $response->siteDetails->exchangeServiceArea ?? null;
        $aaptServiceQualification->distance_to_exchange = $response->siteDetails->distanceToExchange ?? null;
        $aaptServiceQualification->nbn_serviceability_class = $response->siteDetails->nbnServiceabilityClass ?? null;
        $aaptServiceQualification->dsl_codes_on_line = $response->siteDetails->dslCodesOnLine ?? null;

        $aaptSQID = $aaptServiceQualification->id;

        $result = $this->setAddressDetails($aaptServiceQualification, $address);

        foreach ($response->accessQualificationList as $accessQualification) {

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
        $aaptServiceQualification->location_id = $locationId;
        $aaptServiceQualification->product_type = $productType;
        $aaptServiceQualification->aapt_id = $aaptLocationID;
        $aaptServiceQualification->telstra_id = $telstraLocationID;

        $aaptServiceQualification->save();

        return $aaptServiceQualification;
    }

    private function setAddressDetails($aaptServiceQualification, $siteAddress)
    {

        if ($siteAddress === null) {
            return false;
        }

        $planNumber = isset($siteAddress['planNumber']) ? 'SP ' . $siteAddress['planNumber'] : '';

        $streetNumber = $siteAddress['streetNumber'] ?? '';
        $streetNumberSuffix =  $siteAddress['streetNumberSuffix'] ?? '';
        $streetNumber = $streetNumber . $streetNumberSuffix;

        $streetType = $siteAddress['streetType']  ?? '';
        $streetTypeSuffix = $siteAddress['streetTypeSuffix'] ?? '';
        $streetType = $streetType . $streetTypeSuffix;

        $longAddress = implode(' ', array($siteAddress['lotNumber']  ?? '', $planNumber, $siteAddress['unitNumber']  ?? '', $streetNumber, $siteAddress['streetName']  ?? '', $streetType, $siteAddress['suburb']  ?? '', $siteAddress['state']  ?? '', $siteAddress['postcode'] ?? ''));

        $aaptServiceQualification->long_address = strtoupper(trim($longAddress));

        $aaptServiceQualification->lot_number = $siteAddress['lotNumber'] ?? null;
        $aaptServiceQualification->unit_number = $siteAddress['unitNumber'] ?? null;
        $aaptServiceQualification->street_number = $siteAddress['streetNumber'] ?? null;
        $aaptServiceQualification->street_number_suffix = $siteAddress['streetNumberSuffix'] ?? null;
        $aaptServiceQualification->street_name = $siteAddress['streetName'] ?? null;
        $aaptServiceQualification->street_type = $siteAddress['streetType'] ?? null;
        $aaptServiceQualification->street_type_suffix = $siteAddress['streetTypeSuffix'] ?? null;
        $aaptServiceQualification->suburb = $siteAddress['suburb'] ?? null;
        $aaptServiceQualification->state = $siteAddress['state'] ?? null;
        $aaptServiceQualification->postcode = $siteAddress['postcode'] ?? null;
    }
}
