<?php

namespace App\Services\Vocus\Methods;

use SoapFault;

class Get
{

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($setRequest)
    {
        try {
            $response = $this->client->Get($setRequest);

        } catch(SoapFault $fault) {
            return $fault;
        } catch (Exception $e) {
            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
        }

        return $response;
    }

}
