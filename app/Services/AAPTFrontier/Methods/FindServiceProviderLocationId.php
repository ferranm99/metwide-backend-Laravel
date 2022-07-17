<?php

namespace App\Services\AAPTFrontier\Methods;

use Exception;
use Barryvdh\Debugbar\Facade as Debugbar;

use App\Services\AAPTFrontier\Classes\ComplexAddress;
use App\Services\AAPTFrontier\Classes\FindServiceProviderLocationIdRequest;
use App\Services\AAPTFrontier\Classes\FindServiceProviderLocationIdResponse;

use SimpleXMLElement;

class FindServiceProviderLocationId
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($address)
    {

        $complexAddress = new ComplexAddress($address);

        $findServiceProviderLocationIdRequest = new FindServiceProviderLocationIdRequest($complexAddress, null, null);

        try {
            $response = $this->client->findServiceProviderLocationId($findServiceProviderLocationIdRequest);

            return $response->erviceProviderLocationList;

            $serviceProviderLocationList = $response->serviceProviderLocationList->serviceProviderLocationList;

            $findServiceProviderLocationIdResponse = new FindServiceProviderLocationIdResponse($serviceProviderLocationList);

            return $findServiceProviderLocationIdResponse->serviceProviderLocationList;

            $response = json_decode(json_encode($response), true);
            $serviceProviderLocationList = $response['serviceProviderLocationList']['serviceProviderLocationList'];

            $locationIdList = array();
        } catch (Exception $e) {
            $xml = $this->client->__getLastResponse();
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);

            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
            //return "Error findServiceProviderLocationId";
        }
    }

    private function parseNBNLocation()
    {
    }
}
