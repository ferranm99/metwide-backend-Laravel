<?php

namespace App\Services\Vocus\Methods;


class Set
{

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($setRequest)
    {

        try {
            $response = $this->client->Set($setRequest);
        } catch (Exception $e) {
            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
        }

        return $response;
    }

}
