<?php

namespace App\Services\Opticomm\Methods;

use App\Services\Opticomm\Classes\ServiceQualificationRequest;
use App\Services\Opticomm\Classes\ServiceQualificationResponse;

use Barryvdh\Debugbar\Facade as Debugbar;
use League\Flysystem\Exception;

class QualifyService
{

    protected $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function execute($address)
    {

        $lotNumber = $address['lot_identifier'] ?? null;
        $unitNumber = $address['unit_identifier'] ?? null;
        $houseNumber = $address['street_number_1'] ?? null;
        $streetName = $address['street_name'] ?? null;
        $streetType = $address['street_type'] ?? null;
        $suburb = $address['locality_name'] ?? null;
        $stateName = $address['state_territory'] ?? null;
        $postcode = $address['postcode'] ?? null;

        $xmlPostString = '<env:Envelope
        xmlns:env="http://www.w3.org/2003/05/soap-envelope"
        xmlns:ns1="http://schemas.datacontract.org/2004/07/Models"
        xmlns:ns2="http://tempuri.org/"
        xmlns:ns3="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <env:Header>
           <ns3:Security env:mustUnderstand="true">
              <ns3:UsernameToken>
                 <Username>' . $this->options['username'] . '</Username>
                 <Password>' . $this->options['password'] . '</Password>
              </ns3:UsernameToken>
           </ns3:Security>
        </env:Header>
        <env:Body>
           <ns2:ServiceQualification>
              <ns2:request>
                 <ns1:Unit_No>' . $unitNumber . '</ns1:Unit_No>
                 <ns1:House_No>' . $houseNumber . '</ns1:House_No>
                 <ns1:Street_Name>' . $streetName . '</ns1:Street_Name>
                 <ns1:Street_Type>' . $streetType . '</ns1:Street_Type>
                 <ns1:Suburb>' . $suburb . '</ns1:Suburb>
                 <ns1:State_Name>' . $stateName . '</ns1:State_Name>
                 <ns1:Postcode>' . $postcode . '</ns1:Postcode>
              </ns2:request>
           </ns2:ServiceQualification>
        </env:Body>
     </env:Envelope>';


        //return $xmlPostString;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->options['location'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $xmlPostString,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: " . strlen($xmlPostString),
                "Content-Type: text/xml",
                "Host: opticomm-ossb2b.azurewebsites.net",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);

        $xml = $response;
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $xml);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $responseBody = json_decode($json, false);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $responseBody;
            $responseItem = $responseBody->soapenvBody->ServiceQualificationResponse->ServiceQualificationResult->ResponseItem;

            $serviceQualificationResponse = new ServiceQualificationResponse($responseItem);

            return $serviceQualificationResponse;
        }
    }
}
