<?php

namespace App\Http\Responses;


class FakeNoDirectoryResponse
{
    public static function execute()
    {

        $data = [
            "TransactionID" => "170CCC0A62F6SDBX",
            "ResponseType" => "SYNC",
            "Parameters" => [
                "Param" => []
            ],
            "faultstring" => "error",
            "detail" => [
                "FaultResponse" => [
                    "ErrorCode" =>  "DIR-1181"
                ]
            ]
//            detail.FaultResponse.ErrorCode === "DIR-1181"
        ];


        return json_decode(json_encode($data));
    }
}
