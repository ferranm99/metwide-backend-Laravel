<?php

namespace App\Services\Vocus\Methods;


class Delete
{

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function execute($setRequest)
    {

        try {
            $response = $this->client->Delete($setRequest);
        } catch (Exception $e) {
            echo $e->getMessage(), '<br/><br>', $e->getTraceAsString();
        }

        return $response;
    }

}
