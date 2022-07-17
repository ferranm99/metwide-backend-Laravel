<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\InfrastructureAuditRequest;
use App\Models\MetwideCompany;


use App\Mail\InfrastructureAuditRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class HardwareAssetManagementController extends Controller
{

    public function infrastructureAuditRequest(InfrastructureAuditRequest $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new InfrastructureAuditRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
