<?php

namespace App\Services\Opticomm\Actions;

use App\Services\Opticomm\Classes\ServiceQualificationRequest;
use App\Services\Opticomm\Classes\ServiceQualificationResponse;
use App\Models\OpticommPortUtlisation;

use Barryvdh\Debugbar\Facade as Debugbar;

use App\Http\Controllers\OpticommController;


class QualifyFibreAddress
{

    public function execute($serviceQualification)
    {

        $serviceQualificationRequest = new ServiceQualificationRequest($serviceQualification);

        $opticommController = new OpticommController();

        $serviceQualificationResponse = $opticommController->qualifyService($serviceQualificationRequest);

        /*
        $serviceQualification->long_address = $response->location->formattedAddress;
        $serviceQualification->latitude = $response->location->latitude;
        $serviceQualification->longitude = $response->location->longitude;
*/


        $serviceQualification->result = $serviceQualificationResponse->statusCode;
        $serviceQualification->result_code = $serviceQualificationResponse->resultCode;
        $serviceQualification->service_type = 'OPTICOMM';
        if ($serviceQualificationResponse->statusCode === 'SUCCESS') {
            $serviceQualification->stage = $serviceQualificationResponse->stage;
            $serviceQualification->location_id = $serviceQualificationResponse->propertyID;
            $serviceQualification->unit_number = $serviceQualificationResponse->unitNo;
            $serviceQualification->unit_number = $serviceQualificationResponse->houseNo;
            $serviceQualification->lot_number = $serviceQualificationResponse->lotNo;
            $serviceQualification->street_name = $serviceQualificationResponse->streetName;
            $serviceQualification->street_type = $serviceQualificationResponse->streetType;
            $serviceQualification->suburb = $serviceQualificationResponse->suburb;
            $serviceQualification->state = $serviceQualificationResponse->stateName;
            $serviceQualification->postcode = $serviceQualificationResponse->postcode;
            $serviceQualification->estate_name = $serviceQualificationResponse->estateName;
            $serviceQualification->property_class = $serviceQualificationResponse->propertyClass;
        }


        foreach ($serviceQualificationResponse->portUtilisation as $portUtilisation) {

            $opticommPortUtlisation = new OpticommPortUtlisation();

            $opticommPortUtlisation->service_qualification_id = $serviceQualification->id ?? null;
            $opticommPortUtlisation->port_no = $portUtilisation->portNo ?? null;
            $opticommPortUtlisation->product_type = $portUtilisation->productType ?? null;

            $opticommPortUtlisation->save();
        }

        $serviceQualification->save();

        return $serviceQualification;
    }

    /**
     * Convert numeric array into an associative array.
     *
     * @param array $array
     *
     * @return array
     */
    private function getAssocArray($array)
    {

        $assocArray = array();

        $copperPairRecords = array();

        $nbnPortRecords = array();

        for ($i = 0; $i < count($array); $i++) {

            if ($array[$i]->id === 'CopperPairRecord') {
                $xml = simplexml_load_string($array[$i]->_);
                $copperPairRecord = json_decode(json_encode($xml));
                array_push($copperPairRecords, $copperPairRecord);
            } elseif ($array[$i]->id === 'NBNPortRecord') {
                $xml = simplexml_load_string($array[$i]->_);
                $nbnPortRecord = json_decode(json_encode($xml));
                array_push($nbnPortRecords, $nbnPortRecord);
            } else {
                $assocArray[$array[$i]->id] = $array[$i]->_;
            }
        }
        $assocArray['NBNPortRecord'] = $nbnPortRecords;

        $assocArray['CopperPairRecord'] = $copperPairRecords;

        return $assocArray;
    }
}
