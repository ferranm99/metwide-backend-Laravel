<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CaseStudyRequest;
use App\Models\CaseStudyRequest as CaseStudy;
use App\Models\MetwideCompany;


use App\Mail\CaseStudyRequestMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class CaseStudyController extends Controller
{

    public function submitCaseStudyContact(CaseStudyRequest $request)
    {

        $caseStudy = CaseStudy::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'case_study_title' => $request->caseStudyTitle,
        ]);

        $siteCode = strtoupper(config('services.site.code'));

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new CaseStudyRequestMail($request, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
