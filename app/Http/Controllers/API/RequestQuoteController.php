<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\GetQuoteRequest;
use App\Models\WebsiteEnquire;
use App\Models\MetwideCompany;


use App\Mail\GetQuoteRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class RequestQuoteController extends Controller
{


    public function getQuoteRequest(GetQuoteRequest $request)
    {
        $siteCode = 'MWC';
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to_sales');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new GetQuoteRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
