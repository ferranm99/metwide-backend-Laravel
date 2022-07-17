<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ITHealthCheckRequest;
use App\Models\WebsiteEnquire;
use App\Models\MetwideCompany;


use App\Mail\ITHealthCheckRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class RequestITHealthCheckController extends Controller
{

    public function bookITHealthCheck(ITHealthCheckRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new ITHealthCheckRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
