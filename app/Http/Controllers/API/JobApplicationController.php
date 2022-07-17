<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\JobApplicationRequest;
use App\Models\WebsiteEnquire;
use App\Models\MetwideCompany;


use App\Mail\JobApplicationMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class JobApplicationController extends Controller
{

    public function submitJobApplication(JobApplicationRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new JobApplicationMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
