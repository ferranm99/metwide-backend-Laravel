<?php

namespace App\Services\Vocus\Methods;


class Create
{

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($setRequest)
    {

        try {
            $response = $this->client->Create($setRequest);
        } catch (Exception $e) {
            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
        }

        return $response;
    }

}
