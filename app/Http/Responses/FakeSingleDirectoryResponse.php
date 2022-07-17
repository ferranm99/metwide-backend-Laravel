<?php

namespace App\Http\Responses;

class FakeSingleDirectoryResponse
{
    public static function execute()
    {

        $data = [
            "TransactionID" => "170CCC0A62F6SDBX",
            "ResponseType" => "SYNC",
            "Parameters" => [
                "Param" => [
                    0 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240465568</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 GREAT NORTH RD FIVE DOCK 2046 NSW</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord"
                    ]
                ]
            ]
        ];


        return json_decode(json_encode($data));
    }
}
