<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\HelpCentreRequest;
use App\Models\MetwideCompany;


use App\Mail\HelpCentreRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class HelpCentreController extends Controller
{

    public function submitHelpCentreForm(HelpCentreRequest $request)
    {

        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new HelpCentreRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
