<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Helpers\NBN\NbnLookup;

use Illuminate\Support\Arr;


use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;
use Illuminate\Support\Facades\Log;
use LDAP\Result;

class NbnCoAPIController extends Controller
{

    public function nbnLocationIDLookup(Request $request)
    {
        $locationID = $request->get('locationID');
        $nbnLookup = new NbnLookup();

        $result = $nbnLookup->byLocId($locationID);

        return response()->json($result);
    }


    public function getNbnCoLocationIdAddress(Request $request)
    {
        $locationID = $request->get('locationID');
        $nbnLookup = new NbnLookup();

        $result = $nbnLookup->byLocId($locationID);

        $result = json_decode(json_encode($result), true);

        $address = Arr::get($result, 'addressDetail.formattedAddress');

        $address = str_ireplace('Australia', '', $address);

        return response()->json($address);
    }
}
