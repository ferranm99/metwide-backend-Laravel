<?php

namespace App\Helpers\AAPTFrontier\Methods;

use Barryvdh\Debugbar\Facade as Debugbar;

use App\Helpers\AAPTFrontier\Classes\QualifyProductRequest;
use App\Helpers\AAPTFrontier\Classes\ComplexAddress;
use App\Helpers\AAPTFrontier\Classes\QualifyFastFibreProductRequest;

use SoapFault;

class QualifyFastFibre
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($address, $nbnLocationID)
    {
        $complexAddress = new ComplexAddress($address);

        $qualifyFastFibreProductRequest = new QualifyFastFibreProductRequest($complexAddress, $nbnLocationID);

        unset($qualifyFastFibreProductRequest->address);

        $qualifyProductRequest = new QualifyProductRequest(null, null, null, null, null, null, $qualifyFastFibreProductRequest);

        try {
            $response = $this->client->qualifyProduct($qualifyProductRequest);
        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: " . $fault->faultcode . ", faultstring: " . $fault->faultstring . ")", E_USER_ERROR);
        } catch (Exception $e) {
            trigger_error("SOAP Error: " . $e->getMessage(), E_USER_ERROR);
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
