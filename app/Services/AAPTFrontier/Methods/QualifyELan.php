<?php

namespace App\Helpers\AAPTFrontier\Methods;

use Exception;
use Barryvdh\Debugbar\Facade as Debugbar;

use App\Helpers\AAPTFrontier\Classes\QualifyProductRequest;
use App\Helpers\AAPTFrontier\Classes\QualifyELanProductRequest;

class QualifyELan
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($endCSN, $aaptLocationID, $telstraLocationID, $ethernetQosType, $ethernetAccessType)
    {

        $qualifyELanProductRequest = new QualifyELanProductRequest($endCSN, $aaptLocationID, $telstraLocationID, $ethernetQosType, $ethernetAccessType);

        $qualifyProductRequest = new QualifyProductRequest(null, null, $qualifyELanProductRequest, null, null, null, null);

        $response = $this->client->qualifyProduct($qualifyProductRequest);

     //   throw new Exception('foo');
        try {
            $response = $this->client->qualifyProduct($qualifyProductRequest);

        } catch (Exception $e) {
            $xml = $this->client->__getLastResponse();
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);

            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
            //return "Error findServiceProviderLocationId";
        }

        return $response;
    }

    private function parseNBNLocation()
    {
    }
}
