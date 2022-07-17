<?php

namespace App\Actions\Smile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserOnlineStatus
{
    /**
     * Get user online status
     *
     * @param  String  $username
     * @param  String  $date
     * @return array
     */
    public static function get($username)
    {
        $username = "'" . $username . "'";

        $date = Carbon::now('Australia/Sydney')->format('Y-m-d');
        $date = "'" . $date . "'";

        $response = DB::connection('pgsql')->select("SELECT public.bo_get_user_online($username, $date)");

        Log::debug('UserOnlineStatus');
        Log::debug($response);
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

            $starttime = Carbon::make($starttime)->format("d-M-Y H:i:s a");

            $row['username'] = $username;
            $row['starttime'] = $starttime;
            $row['seconds'] = $record[2];
            $row['endtime'] = $record[3];
            $row['assignedaddress'] = $record[4];

            array_push($a, $row);
        }

        return Arr::wrap($a);
    }
}
