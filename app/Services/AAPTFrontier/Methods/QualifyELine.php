<?php

namespace App\Helpers\AAPTFrontier\Methods;

use Exception;
use Barryvdh\Debugbar\Facade as Debugbar;

use App\Helpers\AAPTFrontier\Classes\ELineType;
use App\Helpers\AAPTFrontier\Classes\EthernetAccessType;
use App\Helpers\AAPTFrontier\Classes\QualifyProductRequest;
use App\Helpers\AAPTFrontier\Classes\QualifyELineProductRequest;

class QualifyELine
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($endCSN, $aaptLocationID, $telstraLocationID, $eLineType, $ethernetAccessType)
    {

        $qualifyELineProductRequest = new QualifyELineProductRequest($endCSN, $aaptLocationID, $telstraLocationID,  $eLineType, $ethernetAccessType);

        $qualifyProductRequest = new QualifyProductRequest(null, null, null, $qualifyELineProductRequest, null, null, null);

        try {
            $response = $this->client->qualifyProduct($qualifyProductRequest);

        } catch(SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: " . $fault->faultcode . ", faultstring: " . $fault->faultstring . ")", E_USER_ERROR);
        } catch(Exception $e) {
            trigger_error("SOAP Error: " . $e->getMessage(), E_USER_ERROR);
        }
        finally {
            if (isset($response)) {
                return $response;
            }
            return null;
        }

    }

    private function parseNBNLocation()
    {
    }
}
