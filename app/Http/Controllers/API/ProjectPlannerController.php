<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\MTVProjectPlannerRequest;
use App\Http\Requests\VCProjectPlannerRequest;
use App\Http\Requests\ICTProjectPlannerRequest;
use App\Http\Requests\WDProjectPlannerRequest;
use App\Http\Requests\BuildYourServerRequest;

use App\Models\MetwideCompany;


use App\Mail\MTVProjectPlannerRequestMail;
use App\Mail\VCProjectPlannerRequestMail;
use App\Mail\ICTProjectPlannerRequestMail;
use App\Mail\WDProjectPlannerRequestMail;
use App\Mail\BuildYourServerRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class ProjectPlannerController extends Controller
{

    public function mtvProjectPlannerRequest(MTVProjectPlannerRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new MTVProjectPlannerRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }

    public function vcProjectPlannerRequest(VCProjectPlannerRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new VCProjectPlannerRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }

    public function ictProjectPlannerRequest(ICTProjectPlannerRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new ICTProjectPlannerRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }

    public function wdProjectPlannerRequest(WDProjectPlannerRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new WDProjectPlannerRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }

    public function buildYourServerRequest(BuildYourServerRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new BuildYourServerRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
