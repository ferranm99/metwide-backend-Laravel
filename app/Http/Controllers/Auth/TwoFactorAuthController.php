<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwoFactorAuthController extends Controller
{
    public function confirm(Request $request)
    {
       // return response()->json(["status" => $request->input('sixDigitCode')]);
        $confirmed = $request->user()->confirmTwoFactorAuth($request->input('sixDigitCode'));

        if (!$confirmed) {
            return response()->json(["status" => "Invalid"]);
        }

        return response()->json(["status" => "Valid"]);
    }

    public function update2FA(Request $request)
    {
       // return response()->json(["status" => $request->input('sixDigitCode')]);
        $response = $request->user()->updateTwoFactorConfirmed($request->input('twoFactorConfirmed'));

        if (!$response) {
            return response()->json(["status" => "Error"]);
        }

        return response()->json(["status" => "Updated"]);
    }
}
