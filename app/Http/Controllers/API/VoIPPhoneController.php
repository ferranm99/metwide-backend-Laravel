<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\MobileInternationalRate;

use App\Models\WebsiteOrderCart;
use App\Models\ResidentialOnlineOrder;
use App\Models\MetwideCompany;

use Illuminate\Support\Facades\Mail;

use App\Mail\ConfirmVoIPPhoneOrderMail;

use App\Traits\CreateServiceOrderTrait;
use App\Traits\CreateOrderAddressTrait;
use App\Traits\CreateVoiceServiceOrderTrait;

use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;


class VoIPPhoneController extends Controller
{
    use CreateServiceOrderTrait;
    use CreateOrderAddressTrait;
    use CreateVoiceServiceOrderTrait;

    /**
     * Get list of activity questions.
     * Route: /api/activities/list
     *
     * @param string $destination
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInternationalRates($destination)
    {
        $internationalRates = MobileInternationalRate::where('destination', 'like', '%' . $destination . '%')->orderBy('destination', 'asc')->get();

        return response()->json($internationalRates);
    }

    public function saveStep1(Request $request)
    {


        $referenceNumber = $request->input('referenceNumber') ?? null;

        $websiteOrderCart = WebsiteOrderCart::updateOrCreate(
            ['id' =>  $referenceNumber],
            [
                'site_code' => config('services.site.code'),
                'first_name' => $request->input('firstName') ?? null,
                'last_name' => $request->input('lastName') ?? null,
                'phone_number' => $request->input('phoneNumber') ?? null,
                'email' => $request->input('email') ?? null,
                'address' => $request->input('address') ?? null,
                'service_type' => 'VoIP Phone',
                'plan_name' => $request->input('voipPhonePlan') ?? null,
                'international_call_pack' => $request->input('internationalCallPack') ?? null,
            ]
        );

        return response()->json([
            'status'         => 'Success',
            'orderReference' => $websiteOrderCart->id,
        ]);
    }

    public function saveStep2(Request $request)
    {
        return response()->json([
            'status'         => 'success',
            'orderReference' => $request->input('referenceNumber')
        ]);
    }

    public function saveOrder(Request $request)
    {
        $referenceNumber = $request->input('referenceNumber') ?? null;
        $websiteOrderCart = WebsiteOrderCart::where('id', $referenceNumber)->first();
        $websiteOrderCart->order_submitted = true;

        $serviceOrder = $this->createServiceOrder($request);

        $response = $this->createOrderAddress($serviceOrder, $request);

        $voiceServiceOrder = $this->createVoiceServiceOrder($serviceOrder, $request, 1);

        $voipPhonePlan = $request->input('voipPhonePlan') ?? null;

        $customerEmail = $request->input('email') ?? null;;

        $serviceOrder->total_minimum_cost = $voiceServiceOrder->min_monthly_cost ?? 0;

        $serviceOrder->monthly_cost = $voiceServiceOrder->min_monthly_cost ?? 0;

        $serviceOrder->save();

        $websiteOrderCart->order_reference =  $serviceOrder->order_reference;

        $websiteOrderCart->save();

        // Send Email
        $siteCode = strtoupper($serviceOrder->site_code);

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        Mail::to($customerEmail)
            ->bcc('adam@itango.com.au')
            ->send(new ConfirmVoIPPhoneOrderMail($serviceOrder, $voiceServiceOrder, $metwideCompany));

        return response()->json([
            'status'         => 'success',
            'orderReference' => $serviceOrder->order_reference
        ]);
    }
}
