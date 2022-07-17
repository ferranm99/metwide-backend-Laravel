<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Responses\FakeGetDirectoryResponse;
use App\Http\Responses\FakeNoDirectoryResponse;
use App\Http\Responses\FakeSingleDirectoryResponse;
use Illuminate\Http\Request;

use App\Services\Nbn\NbnLookup;

use App\Models\WebServiceQualifyRequest;

use App\Services\Vocus\SoapClient\VocusConsumer;
use App\Services\Vocus\Classes\QualifyResponse;
use App\Services\Vocus\Classes\SetRequest;
use App\Services\Vocus\Classes\Parameters;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use SoapClient;

class VocusController extends Controller
{
    /**
     * GET operation
     *
     * @param String $productId
     * @param String $planId
     * @param String $scope
     * @param String $profile
     * @param Array $requestParams
     *
     * @return Mixed
     */
    public function get($productId, $planId, $scope, $profile, $requestParams)
    {
        $accessKey = config('services.vocus.access_key');

        $aliasKey = null;

        $parameters = new Parameters($requestParams);

        $setRequest = new SetRequest($accessKey, $aliasKey, $productId, $planId, $scope, $profile, $parameters);
        $vocusConsumer = $this->getSoapConsumer();

        $response = $vocusConsumer->get($setRequest);

        return $response;
    }


    /**
     * Get locationID(s) for the provided address
     *
     * @param Request $request
     *
     * @return Array
     */
    public function getNBNLocationID(Request $request)
    {

        $params = $request->get('params');
        $address = $params['address'];
        $addressMetadata = $params['addressMetadata'];

        $pageSource = $params['pageSource'];
        $startTime = microtime(true);
        $webServiceQualifyRequest = WebServiceQualifyRequest::create(
            [
                'address' => $address,
                'page_source'      => $pageSource,
                'service'          => 'Business NBN',
                'site'          => config('services.site.code'),
                'start_time' => $startTime,
            ]
        );

        $sqRequestId = $webServiceQualifyRequest->id;

        // $result = $this->checkNBNAddress($address);

        if (config('services.vocus.vocus_test') === true) {
            //            sleep(2);
            //            $response = FakeNoDirectoryResponse::execute();
            $response = FakeSingleDirectoryResponse::execute();
            //            $response = FakeGetDirectoryResponse::execute();
        } else {
            $address = $this->formatVocusAddress($addressMetadata);
            $response = $this->get('DIR', 'BROADBAND', null, null, $address);
        }

        $faultString = $response->faultstring ?? null;

        if ($faultString != null) {
            return [
                'status' => 'SOAPFault',
                'dir_transaction_id' => $response->detail->FaultResponse->TransactionID ?? null,
                //  'soap_error'        => $response->detail->FaultResponse->ErrorCode,
                'soap_error'        => $response,
            ];
        }

        $params = is_array($response->Parameters->Param) ? $response->Parameters->Param : [$response->Parameters->Param];

        $directories = collect($params)->map(function ($p) {
            $xml = simplexml_load_string($p->_);

            return json_decode(json_encode($xml));
        });

        return [
            'status' => 'success',
            'dir_transaction_id' => $response->TransactionID,
            'directories'        => $directories,
            'sq_request_id'     => $sqRequestId,
        ];
    }

    public function qualifyLocationID(Request $request)
    {
        $locationId = $request->get('directoryId');
        $sqRequestId = $request->get('sqRequestId');

        $requestParams = array();

        $requestParams['DirectoryID'] = $locationId;

        if (config('services.vocus.vocus_test') === true) {
            //            sleep(2);

            // Fake responses
            $response = json_decode('{"transactionID":"1726340F6C61380","responseType":"SYNC","result":"PASS","serviceType":"FTTN","serviceClass":"13","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA200000010167","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":"Auto-Assigned","trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":[{"copperPairID":"CPI300001354101","copperPairStatus":"N\/A","nbnServiceStatus":"Line In Use","serviceClass":"13","potsInterconnect":"N\/A","potsMatch":"FALSE","uploadSpeed":"15-37","downloadSpeed":"42-46","networkCoExist":"FALSE","extraCharge":"FALSE"}],"activationDate":null,"copperDisconnectionDate":"20180511"}');
            // $response = json_decode('{"transactionID":"172635E6EA41601","responseType":"SYNC","result":"PASS","serviceType":"FTTB","serviceClass":"13","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA200000001052","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":null,"trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":[{"copperPairID":"CPI300006260457","copperPairStatus":"Inactive","nbnServiceStatus":"N\/A","serviceClass":"12","potsInterconnect":"N\/A","potsMatch":"FALSE","uploadSpeed":"26-40","downloadSpeed":"75-100","networkCoExist":"TRUE","extraCharge":"TRUE"},{"copperPairID":"CPI300003453103","copperPairStatus":"N\/A","nbnServiceStatus":"Line In Use","serviceClass":"13","potsInterconnect":"N\/A","potsMatch":"FALSE","uploadSpeed":"38-40","downloadSpeed":"95-100","networkCoExist":"TRUE","extraCharge":"FALSE"}],"activationDate":null,"copperDisconnectionDate":"20190308"}');
            //             $response = json_decode('{"transactionID":"172635E6EA41601","responseType":"SYNC","result":"PASS","serviceType":"FTTB","serviceClass":"13","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA200000001052","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":null,"trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":[{"copperPairID":"CPI300006260457","copperPairStatus":"Inactive","nbnServiceStatus": "Line In Use","serviceClass":"12","potsInterconnect":"N\/A","potsMatch":"FALSE","uploadSpeed":"26-40","downloadSpeed":"75-100","networkCoExist":"TRUE","extraCharge":"TRUE"},{"copperPairID":"CPI300003453103","copperPairStatus":"N\/A","nbnServiceStatus":"Line In Use","serviceClass":"13","potsInterconnect":"N\/A","potsMatch":"FALSE","uploadSpeed":"38-40","downloadSpeed":"95-100","networkCoExist":"TRUE","extraCharge":"FALSE"}],"activationDate":null,"copperDisconnectionDate":"20190308"}');
            //             $response = json_decode('{"transactionID":"1726344C6101515","responseType":"SYNC","res   sult":"PASS","serviceType":"WIRELESS","serviceClass":"6","dataPort":"TRUE","voicePort":"FALSE","nbnPortRecord":[{"ntdid":"NTD000041016740","portNumber":"1","portName":"1-UNI-D1","available":"FALSE","portType":"Data"},{"ntdid":"NTD000041016740","portNumber":"2","portName":"1-UNI-D2","available":"TRUE","portType":"Data"},{"ntdid":"NTD000041016740","portNumber":"3","portName":"1-UNI-D3","available":"TRUE","portType":"Data"},{"ntdid":"NTD000041016740","portNumber":"4","portName":"1-UNI-D4","available":"TRUE","portType":"Data"}],"csa":"CSA400000000027","cvcid":"Auto-Assigned","zone":"Remote","voiceCVCID":"Auto-Assigned","trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":"NTD000041016740","battery":"FALSE","connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":null,"activationDate":null,"copperDisconnectionDate":"20190402"}');
            // $response = json_decode('{"transactionID":"172635C66FC1540","responseType":"SYNC","result":"PASS","serviceType":"WIRELESS","serviceClass":"5","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA200000010850","cvcid":"Auto-Assigned","zone":"Remote","voiceCVCID":"Auto-Assigned","trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecod":null,"activationDate":null,"copperDisconnectionDate":"20141003"}');
            // $response = json_decode('{"transactionID":"1726356666F1300","responseType":"SYNC","result":"PASS","serviceType":"HFC","serviceClass":"24","dataPort":"FALSE","voicePort":"FALSE","nbnPortRecord":[{"ntdid":"NTD400022285153","portNumber":"1","portName":"1-UNI-D1","available":"FALSE","portType":"Data"}],"csa":"CSA200000000164","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":null,"trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":"NTD400022285153","battery":"FALSE","connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":null,"activationDate":null,"copperDisconnectionDate":"20201009"}');
            // $response = json_decode('{"transactionID":"1726357973A1356","responseType":"SYNC","result":"PASS","serviceType":"HFC","serviceClass":"22","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA500000000721","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":"Auto-Assigned","trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":null,"activationDate":null,"copperDisconnectionDate":"20210115"}');
            //             $response = json_decode('{"transactionID":"17263613BF51686","responseType":"SYNC","result":"FIBRE","serviceType":"FIBRE","serviceClass":"3","dataPort":"TRUE","voicePort":"TRUE","nbnPortRecord":[{"ntdid":"NTD000022858367","portNumber":"1","portName":"1-UNI-D1","available":"FALSE","portType":"Data"},{"ntdid":"NTD000022858367","portNumber":"2","portName":"1-UNI-D2","available":"TRUE","portType":"Data"},{"ntdid":"NTD000022858367","portNumber":"3","portName":"1-UNI-D3","available":"TRUE","portType":"Data"},{"ntdid":"NTD000022858367","portNumber":"4","portName":"1-UNI-D4","available":"TRUE","portType":"Data"},{"ntdid":"NTD000022858367","portNumber":"1","portName":"1-UNI-V1","available":"TRUE","portType":"Voice"},{"ntdid":"NTD000022858367","portNumber":"2","portName":"1-UNI-V2","available":"TRUE","portType":"Voice"}],"csa":"CSA400000000144","cvcid":"Auto-Assigned","zone":"Urban","voiceCVCID":"Auto-Assigned","trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":"NTD000022858367","battery":"FALSE","connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":null,"activationDate":null,"copperDisconnectionDate":"20160909"}');

            //            $response = json_decode('{"transactionID":"172635FD0861643","responseType":"SYNC","result":"REJECTED","serviceType":"NA","serviceClass":"8","dataPort":null,"voicePort":null,"nbnPortRecord":null,"csa":"CSA100000011053","cvcid":null,"zone":"Isolated","voiceCVCID":null,"trafficClass1":null,"trafficClass2":null,"trafficClass3":null,"trafficClass4":null,"availableCTAG":null,"stag":null,"ntdid":null,"battery":null,"connectionType":"Type 1","developmentCharge":"FALSE","copperPairRecord":null,"activationDate":null,"copperDisconnectionDate":null}');
            //$response = json_decode('{"timestamp":1624306869653,"location":{"id":"LOC000074924530","formattedAddress":"LOT 31 101A WATERFALL DR WONGAWALLAN QLD 4210 Australia","latitude":-27.88343523,"longitude":153.22088216,"postcode":"4210"},"servingArea":{"csaId":"CSA400000000815","techType":"FTTC","serviceType":"Fixed line","serviceStatus":"in_construction","serviceCategory":"brownfields","rfsMessage":"Jun 2021","description":"Oxenford"},"addressDetail":{"id":"LOC000074924530","csaId":"CSA400000000815","latitude":-27.88343523,"longitude":153.22088216,"addressStatus":"0","serviceType":"Fixed line","serviceStatus":"in_construction","serviceCategory":"brownfields","disconnectionStatus":"DEFAULT","techType":"FTTC","serviceabilityMessage":"Jun 2021","formattedAddress":"LOT 31 101A WATERFALL DR WONGAWALLAN QLD 4210 Australia","ee":false}}');

            return response()->json($response);
        } else {
            $response = $this->get('FIBRE', null, 'QUALIFY', null, $requestParams);

            $webServiceQualifyRequest = WebServiceQualifyRequest::where('id', $sqRequestId)->first();
            $duration = microtime(true) - $webServiceQualifyRequest->start_time;
            $webServiceQualifyRequest->duration = $duration;

            $qualifyResponse = new QualifyResponse($response);

            $serviceabilityMessage = null;
            if ($qualifyResponse->result === 'REJECTED') {
                $nbnLookup = new NbnLookup();

                $result = $nbnLookup->byLocId($locationId);
                return response()->json($result);
                $addressDetail = $result->addressDetail ?? null;
                if ($addressDetail != null) {
                    $serviceabilityMessage = $addressDetail->serviceabilityMessage ?? null;
                    $nbncoServiceStatus = $addressDetail->serviceStatus ?? null;
                }

                $qualifyResponse->serviceabilityMessage = $serviceabilityMessage;
                $qualifyResponse->nbncoServiceStatus = $nbncoServiceStatus;
            }

            $webServiceQualifyRequest->status = $qualifyResponse->result;
            $webServiceQualifyRequest->location_id = $locationId;
            $webServiceQualifyRequest->access_type = $qualifyResponse->serviceType;
            $webServiceQualifyRequest->save();

            return response()->json($qualifyResponse);
        }
    }


    /**
     * Get locationID(s) for the provided address
     *
     * @param Request $request
     *
     * @return Array
     */
    public function myAccountGetNBNLocationID(Request $request)
    {

        $address = $request->get('address');
        $addressMetadata = $request->get('addressMetadata');

        // $result = $this->checkNBNAddress($address);

        $address = $this->formatVocusAddress($addressMetadata);
        $response = $this->get('DIR', 'BROADBAND', null, null, $address);

        $faultString = $response->faultstring ?? null;

        if ($faultString != null) {
            return [
                'status' => 'SOAPFault',
                'dir_transaction_id' => $response->detail->FaultResponse->TransactionID ?? null,
                //  'soap_error'        => $response->detail->FaultResponse->ErrorCode,
                'soap_error'        => $response,
            ];
        }

        $params = Arr::wrap($response->Parameters->Param);

        $directories = collect($params)->map(function ($p) {
            $xml = simplexml_load_string($p->_);

            return json_decode(json_encode($xml));
        });

        return [
            'status' => 'success',
            'dir_transaction_id' => $response->TransactionID,
            'directories'        => $directories,
        ];
    }

    /**
     * Qualify location ID
     *
     * @param  Request  $request
     * @return Array
     */
    public function myAccountQualifyLocationID(Request $request)
    {

        $locationID = $request->get('locationID');

        $nbnCoAddressData = $this->parseNbnCoAddress($locationID);

        $requestParams = array();

        $requestParams['DirectoryID'] = $locationID;

        $fnn = $request->get('fnn') ?? null;

        if ($fnn !== null) {
            $requestParams['CarrierID'] = $request->get('fnn');
        }

        $response = $this->get('FIBRE', null, 'QUALIFY', null, $requestParams);

        $qualifyResponse = new QualifyResponse($response);

        return response()->json([
            'sqResult' => $qualifyResponse,
            'address' => $nbnCoAddressData['address'],
            'nbnCoAddressData' => $nbnCoAddressData,
        ]);
    }

    /**
     * Check the address if NBN enabled
     *
     * @param  String $address
     *
     * @return Mixed
     */
    private function checkNBNAddress($address)
    {

        $nbnLookup = new NbnLookup();

        $result = $nbnLookup->byAddress($address);

        return $result;
    }

    public function checkNBNCo($locationId)
    {
        $ch = curl_init();

        $url = 'https://places.nbnco.net.au/places/v1/details/' . $locationId;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Referer: https://www.nbnco.com.au/';
        $headers[] = 'X-Nbn-Sender-Id: nbn-website';
        $headers[] = 'X-Nbn-Breadcrumb-Id: 1234567038421-699';
        $headers[] = 'Origin: https://www.nbnco.com.au';
        $headers[] = 'Connection: keep-alive';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return json_decode($result);
    }

    /**
     * Get a VocusConsumer instance
     *
     * @return VocusConsumer
     */
    public function getSoapConsumer()
    {
        $response = $this->wsmLogin('prod');

        $wsdl = storage_path('/vocus/soap/WholesaleServiceManagement.wsdl');

        $location = 'https://wsm.webservice.m2.com.au/WholesaleServiceManagement';

        $options = array();
        $options['trace'] = true;
        $options['exceptions'] = true;
        $options['location'] = $location;

        try {
            $soapClient = new SoapClient($wsdl, $options);
            $consumer = new VocusConsumer($soapClient);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $consumer;
    }


    /**
     * Call to login
     *
     * @return Boolean
     */
    public function wsmLogin($environment)
    {

        if ($environment === 'dev') {
            $localCert = storage_path('vocus/soap/metwidesdbx.pem');
            $url = 'https://203.23.116.113:9443/login/';
            $password = config('services.vocus.dev_key_password');
        } elseif ($environment === 'prod') {
            $localCert = storage_path('vocus/soap/metwideprod.pem');
            $url = 'https://203.23.116.112:9443/login/';
            $password = config('services.vocus.key_password');
        }


        $ch = curl_init();

        //curl_setopt($ch, CURLOPT_URL, 'https://wsm.webservice.m2.com.au:9443/login/');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, $localCert);
        curl_setopt($ch, CURLOPT_KEYPASSWD, $password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $result = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        #
        curl_close($ch);

        return true;
    }

    /**
     * Create an address array for Vocus.
     *
     * @param Array $attributes
     *
     * @return array
     */
    private function formatVocusAddress($attributes)
    {
        $address = array();

        $streetNumber = $attributes['street_number_1'];

        $streetNumberParts = preg_split('#(?<=\d)(?=[a-z])#i', $streetNumber);

        $address['Main.Unit1stNumber'] = $attributes['unit_identifier'];
        $address['Main.Street1stNumber'] = $streetNumberParts[0] ?? null;
        $address['Main.Street1stNumberSuffix'] = $streetNumberParts[1] ?? null;
        $address['Main.StreetName'] = $attributes['street_name'];
        $address['Main.StreetType'] = $attributes['street_type'] ?? 'Street';
        $address['Main.StreetSuffix'] = $attributes['street_suffix'];
        $address['Main.Suburb'] = $attributes['locality_name'];
        $address['Main.Postcode'] = $attributes['postcode'];
        $address['Main.State'] = $attributes['state_territory'];

        return $address;
    }

    public function parseNbnCoAddress($locationID)
    {
        $nbnLookup = new NbnLookup();

        $result = $nbnLookup->byLocId($locationID);

        $result = json_decode(json_encode($result), true);


        $address = Arr::get($result, 'addressDetail.formattedAddress');
        $address = str_ireplace('Australia', '', $address);
        $streetAddress = Arr::get($result, 'addressDetail.address1');
        $localityAddress = Arr::get($result, 'addressDetail.address2');
        $localityAddress = str_ireplace('Australia', '', $localityAddress);
        $regex = '/s*(?P<state>NSW|ACT|NT|QLD|SA|TAS|VIC|WA)\s*(?P<postcode>\d{4})/';

        preg_match_all($regex, $address, $matches, PREG_SET_ORDER, 0);

        $matches = Arr::dot($matches);

        $state = $matches['0.state'];
        $postcode = $matches['0.postcode'];

        return [
            'address' => $address,
            'streetAddress' => $streetAddress,
            'localityAddress' => $localityAddress,
            'state' => $state,
            'postcode' => $postcode,
        ];
    }
}
