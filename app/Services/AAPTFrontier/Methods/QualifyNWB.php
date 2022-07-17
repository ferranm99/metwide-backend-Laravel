<?php

namespace App\Helpers\AAPTFrontier\Methods;

use Exception;
use Barryvdh\Debugbar\Facade as Debugbar;

use App\Helpers\AAPTFrontier\Classes\QualifyProductRequest;
use App\Helpers\AAPTFrontier\Classes\QualifyNationalWholesaleBroadbandProductRequest;

class QualifyNWB
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($nbnLocationId)
    {

        $qualifyNationalWholesaleBroadbandProductRequest = new QualifyNationalWholesaleBroadbandProductRequest(null, null, $nbnLocationId, null, null, null, null, null);

        $qualifyProductRequest = new QualifyProductRequest($qualifyNationalWholesaleBroadbandProductRequest, null, null, null, null, null, null);

        try {
            $response = $this->client->qualifyProduct($qualifyProductRequest);

        } catch (Exception $e) {
            $xml = $this->client->__getLastResponse();
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);

            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
            //return "Error findServiceProviderLocationId";
        } finally {
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
