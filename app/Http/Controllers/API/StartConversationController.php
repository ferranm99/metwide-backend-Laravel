<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CreateWebsiteEnquire;
use App\Models\WebsiteEnquire;
use App\Models\MetwideCompany;
//use Mail;

use App\Mail\WebsiteEnquirySupportMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StartConversationController extends Controller
{

    public function startConversationRequest(CreateWebsiteEnquire $request)
    {
        $siteCode = strtoupper(config('services.site.code'));

        $serviceType = $request->get('serviceType');

        $websiteEnquiry = WebsiteEnquire::create([
            "name"              => $request->get('name'),
            "email"             => $request->get('email'),
            "phone"             => $request->get('phone'),
            //"state"             => $request->get('state'),
            //"property_type"     => $request->get('property_type'),
            //"best_time_to_call" => $request->get('best_time_to_call'),
            //"current_customer"  => $request->get('current_customer') === 'Yes',
            "enquiry_type"      => 'Start the Conversation - ' . $serviceType,
            "enquiry_message"   => $request->get('message'),
            "status"            => "New",
            "site_code"         => $siteCode,

            //          todo: What is this field???
            //            "date_closed"            => "New"
        ]);


        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        $mailTo = config('app.mail_to_sales');
        $mailToBcc = explode(',', config('app.mail_to_bcc'));
        $mailToBcc = Arr::wrap($mailToBcc);
        $mailToBccStartConversation = config('app.mail_to_bcc_start_conversation');
        if ($mailToBccStartConversation) {
            array_push($mailToBcc, $mailToBccStartConversation);
        }

        Mail::to($mailTo)
            ->bcc($mailToBcc ?: [])
            ->send(new WebsiteEnquirySupportMail($websiteEnquiry, $serviceType, $metwideCompany));

        return response()->json(["status" => "Success"]);
    }
}
