<?php

namespace App\Http\Responses;


class FakeGetDirectoryResponse
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
                    ],
                    1 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479500</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 1</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    2 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479501</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 2</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    3 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479502</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 3</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    4 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479503</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 4</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    5 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479504</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 5</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    6 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479505</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 6</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    7 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479506</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 7</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                    8 => [
                        "_" => "<BroadbandAddressRecord><DirectoryID>240479507</DirectoryID><Carrier>Telstra</Carrier><AddressLong>223 LYONS RD RUSSELL LEA 2046 NSW 8</AddressLong></BroadbandAddressRecord>",
                        "id" => "BroadbandAddressRecord",
                    ],
                ]
            ]
        ];


        return json_decode(json_encode($data));
    }
}

