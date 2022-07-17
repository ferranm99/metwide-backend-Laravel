<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ContactUsRequest;
use App\Models\WebsiteEnquire;
use App\Models\MetwideCompany;


use App\Mail\ContactUsRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{

    public function submitContactUsRequest(ContactUsRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new ContactUsRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
