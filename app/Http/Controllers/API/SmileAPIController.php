<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Actions\Smile\UserOnlineStatus;

class SmileAPIController extends Controller
{

    public function getUserOnlineStatus(Request $request)
    {
        $username = $request->get('username');
        $username = "'" . $username . "'";

        $date = $request->get('date');
        $date = "'" . $date . "'";

         $response = DB::connection('pgsql')->select("SELECT public.bo_get_user_online($username, $date)");

        $a = [];
        foreach ($response as $record) {
            $row = [];

            $text = $record->bo_get_user_online;
            $pattern = "#\((.*?)\)#";
            //Remove parentheses from the response
            preg_match($pattern, $text, $match);

            $record = explode(",", $match[1]);
            $username = $record[0];
            // remove double quotes
            $starttime = str_replace('"', "", $record[1]);

            $row['username'] = $username;
            $row['starttime'] = $record[1];
            $row['seconds'] = $record[2];
            $row['assignedaddress'] = $record[3];

            array_push($a, $row);
        }
        
        return response()->json($a[0]);
    }
}
