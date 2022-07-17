<?php

namespace App\Services\Vocus\Actions;

use App\Models\VocusCopperPairRecord;
use App\Models\NBNPortRecord;

use App\Helpers\Vocus\Classes\QualifyResponse;

use Barryvdh\Debugbar\Facade as Debugbar;

use App\Http\Controllers\VocusController;
use Exception;

class QualifyNBNLocation
{


    public function execute($serviceQualification)
    {

        $vocusController = new VocusController();

        $requestParams = array();

        $requestParams['DirectoryID'] = $serviceQualification->location_id;

        $response = $vocusController->checkNBNCo($serviceQualification->location_id);


        $serviceQualification->long_address = $response->location->formattedAddress;
        $serviceQualification->latitude = $response->location->latitude;
        $serviceQualification->longitude = $response->location->longitude;

        $response = $vocusController->get('FIBRE', null, 'QUALIFY', null, $requestParams);
        Debugbar::info('HERE');
        Debugbar::info($response);
        Debugbar::info('NOW HERE');
        $qualifyResponse = new QualifyResponse($response);

        Debugbar::info($qualifyResponse);

        return json_encode($qualifyResponse);

        throw new Exception('foo');

        $responseParameters = $this->getAssocArray($response->Parameters->Param);

        $serviceQualification->qualify_tx_id = $response->TransactionID;
        $serviceQualification->result = $responseParameters['Result'];
        $serviceQualification->service_type = $responseParameters['ServiceType'] ?? null;
        $serviceQualification->service_class = $responseParameters['ServiceClass'] ?? null;
        $serviceQualification->connection_type = $responseParameters['ConnectionType'] ?? null;
        $serviceQualification->development_charge = strtolower($responseParameters['DevelopmentCharge']) === 'false' ? false : true;
        $serviceQualification->csa = $responseParameters['CSA'] ?? null;
        $serviceQualification->cvcid = $responseParameters['CVCID'] ?? null;
        $serviceQualification->voice_cvcid = $responseParameters['VoiceCVCID'] ?? null;
        $serviceQualification->activation_date = $responseParameters['ActivationDate'] ?? null;
        $serviceQualification->copper_disconnection_date = $responseParameters['CopperDisconnectionDate'] ?? null;
        $serviceQualification->zone = $responseParameters['Zone'] ?? null;

        foreach ($responseParameters['CopperPairRecord'] as $copperPairRecord) {

            $vocusCopperPairRecord = new VocusCopperPairRecord();

            $vocusCopperPairRecord->service_qualification_id = $serviceQualification->id ?? null;
            $vocusCopperPairRecord->copper_pair_id = $copperPairRecord->CopperPairID ?? null;
            $vocusCopperPairRecord->copper_pair_status = $copperPairRecord->CopperPairStatus ?? null;
            $vocusCopperPairRecord->nbn_service_status = $copperPairRecord->NBNServiceStatus ?? null;
            $vocusCopperPairRecord->pots_interconnect = $copperPairRecord->POTSInterconnect ?? null;
            $vocusCopperPairRecord->pots_match = strtolower($copperPairRecord->POTSMatch) === 'false' ? false : true;
            $vocusCopperPairRecord->upload_speed = $copperPairRecord->UploadSpeed ?? null;
            $vocusCopperPairRecord->download_speed = $copperPairRecord->DownloadSpeed ?? null;
            $vocusCopperPairRecord->network_co_exist = strtolower($copperPairRecord->NetworkCoExist) === 'false' ? false : true;
            $vocusCopperPairRecord->save();
        }

        foreach ($responseParameters['NBNPortRecord'] as $sqNbnPortRecord) {

            $nbnPortRecord = new NBNPortRecord();

            $nbnPortRecord->service_qualification_id = $serviceQualification->id ?? null;
            $nbnPortRecord->ntdid = $sqNbnPortRecord->NTDID ?? null;
            $nbnPortRecord->port_number = $sqNbnPortRecord->PortNumber ?? null;
            $nbnPortRecord->port_name = $sqNbnPortRecord->PortName ?? null;
            $nbnPortRecord->available = strtolower($sqNbnPortRecord->Available) === 'false' ? false : true;
            $nbnPortRecord->port_type = $sqNbnPortRecord->PortType;
            $nbnPortRecord->save();
        }


        $serviceQualification->ntdid = $response->NTDID ?? null;

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
