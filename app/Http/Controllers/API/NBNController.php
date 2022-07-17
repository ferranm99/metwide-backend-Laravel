<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\NbnInterestRegisterRequest;
use App\Http\Responses\FakeGetDirectoryResponse;
use App\Http\Responses\FakeNoDirectoryResponse;
use App\Http\Responses\FakeSingleDirectoryResponse;
use App\Mail\ConfirmNBNOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\WebsiteOrderCart;
use App\Models\ServiceOrder;
use App\Models\AccountSubscription;
use App\Models\DataPlan;
use App\Models\VoicePlan;
use App\Models\MetwideCompany;
use App\Models\NbnInterestRegister;
use App\Models\Address;

use App\Helpers\GeneratePassword;
use App\Models\BroadbandServiceOrder;
use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Output\NullOutput;

use App\Traits\CreateServiceOrderTrait;
use App\Traits\CreateOrderAddressTrait;
use App\Traits\CreateBroadbandServiceOrderTrait;
use App\Traits\CreateServiceQualificationTrait;
use App\Traits\CreateVoiceServiceOrderTrait;

class NBNController extends Controller
{
    use CreateServiceOrderTrait;
    use CreateOrderAddressTrait;
    use CreateBroadbandServiceOrderTrait;
    use CreateServiceQualificationTrait;
    use CreateVoiceServiceOrderTrait;

    public function getNBNData()
    {
        return response()->json([
            'benefits' => __('nbn.benefits')
        ]);
    }

    public function getNBNBenefitsData()
    {
        return response()->json([
            'benefits' => __('nbn-benefits.benefits')
        ]);
    }

    public function getNBNAboutData()
    {
        return response()->json([
            'about'       => __('nbn-about.about'),
            'differences' => __('nbn-differences.differences')
        ]);
    }

    public function getNBNCoverageData()
    {
        return response()->json([]);
    }

    public function getNBNQAData()
    {
        return response()->json([
            'qa' => __('nbn-q&a.qa'),
        ]);
    }

    public function getNBNTCData()
    {
        return response()->json([
            'tc' => __('nbn-t&c.tc'),
        ]);
    }

    public function getNBNOrderTCData()
    {
        return response()->json([
            'tc' => __('nbn-order-t&c.tc'),
            'confirm' => __('nbn-order-t&c.confirm'),
        ]);
    }


    public function getCalculatorData()
    {
        return response()->json([
            'deliveryCost'           => 0,
            'downloadSpeedPlans'     => [
                [
                    'title'        => 'Basic',
                    'basePrice'    => 44.99,
                    'value'        => 12,
                    'eveningSpeed' => 10,
                    'bg'           => 'bg-step2-200',
                    'icon'         => '<svg viewBox="0 0 62 61" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.000106812 48.589L0.000107078 60.8012H12.0759C12.0759 54.0641 6.6619 48.5889 0.000106812 48.589Z" fill="#fff"/>
<path d="M0 32.3059L9.28608e-05 40.4473C11.1098 40.4473 20.1264 49.5659 20.1264 60.8012H28.1769C28.1771 45.0677 15.5578 32.3059 0 32.3059Z" fill="#E0E0E0"/>
<path d="M9.15527e-05 16.0229V24.1645C20.0057 24.1645 36.2275 40.5696 36.2275 60.8012H44.2781C44.2781 36.0714 24.4536 16.0229 9.15527e-05 16.0229Z" fill="#E0E0E0"/>
<path d="M0.00012207 0V8.11498C29.1563 8.11498 53.0214 31.2867 53.0214 60.8012H61.1428C61.1428 24.7245 35.6385 0 0.00012207 0Z" fill="#E0E0E0"/>
</svg>'
                ], [
                    'title'        => 'Boost',
                    'basePrice'    => 59.99,
                    'value'        => 25,
                    'eveningSpeed' => 22,
                    'bg'           => 'bg-step2-300',
                    'icon'         => '<svg viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.000106812 49.4944L0.000107078 61.7066H12.0759C12.0759 54.9695 6.6619 49.4942 0.000106812 49.4944Z" fill="white"/>
<path d="M0 33.2113L9.28608e-05 41.3527C11.1098 41.3527 20.1264 50.4712 20.1264 61.7066H28.1769C28.1771 45.973 15.5578 33.2113 0 33.2113Z" fill="white"/>
<path d="M9.15527e-05 16.9282V25.0698C20.0057 25.0698 36.2275 41.4749 36.2275 61.7066H44.2781C44.2781 36.9767 24.4536 16.9282 9.15527e-05 16.9282Z" fill="#E0E0E0"/>
<path d="M0.00012207 0.905334V9.02031C29.1563 9.02031 53.0214 32.192 53.0214 61.7066H61.1428C61.1428 25.6299 35.6385 0.905334 0.00012207 0.905334Z" fill="#E0E0E0"/>
</svg>'
                ], [
                    'title'        => 'Premium',
                    'basePrice'    => 69.99,
                    'value'        => 50,
                    'eveningSpeed' => 43,
                    'bg'           => 'bg-step2-400',
                    'icon'         => '<svg viewBox="0 0 62 61" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.857101 48.589L0.857102 60.8012H12.9329C12.9329 54.0641 7.51889 48.5889 0.857101 48.589Z" fill="white"/>
<path d="M0.856995 32.3059L0.857087 40.4473C11.9668 40.4473 20.9833 49.5659 20.9833 60.8012H29.0339C29.0341 45.0677 16.4148 32.3059 0.856995 32.3059Z" fill="white"/>
<path d="M0.857086 16.0228V24.1644C20.8627 24.1644 37.0845 40.5696 37.0845 60.8012H45.1351C45.1351 36.0713 25.3106 16.0228 0.857086 16.0228Z" fill="white"/>
<path d="M0.857117 -3.05176e-05V8.11495C30.0133 8.11495 53.8784 31.2866 53.8784 60.8012H61.9998C61.9998 24.7245 36.4955 -3.05176e-05 0.857117 -3.05176e-05Z" fill="#E0E0E0"/>
</svg>'
                ], [
                    'title'        => 'Superfast',
                    'basePrice'    => 79.99,
                    'value'        => 100,
                    'eveningSpeed' => 77,
                    'bg'           => 'bg-step2-500',
                    'icon'         => '<svg viewBox="0 0 62 61" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.714096 48.589L0.714096 60.8012H12.7899C12.7899 54.0641 7.37589 48.5889 0.714096 48.589Z" fill="white"/>
<path d="M0.713989 32.3059L0.714082 40.4474C11.8238 40.4474 20.8403 49.5659 20.8403 60.8012H28.8909C28.891 45.0677 16.2718 32.3059 0.713989 32.3059Z" fill="white"/>
<path d="M0.714081 16.0229V24.1644C20.7197 24.1644 36.9415 40.5696 36.9415 60.8012H44.992C44.992 36.0714 25.1676 16.0229 0.714081 16.0229Z" fill="white"/>
<path d="M0.714111 0V8.11498C29.8703 8.11498 53.7354 31.2867 53.7354 60.8012H61.8568C61.8568 24.7245 36.3525 0 0.714111 0Z" fill="white"/>
</svg>'
                ]
            ],
            'monthlyDataPlans'       => [
                [
                    'title' => '100 GB',
                    'price' => 0,
                    'bg'    => 'bg-step3-200',
                    'icon'  => '<svg viewBox="0 0 224 224" fill="none"><circle cx="112.421" cy="112" r="111.459" fill="white"></circle><path d="M112.421 223.459C138.208 223.459 163.197 214.518 183.13 198.159C203.064 181.8 216.708 159.036 221.739 133.745C226.769 108.453 222.875 82.2003 210.719 59.4585C198.564 36.7166 178.899 18.8932 155.075 9.0251C131.251 -0.843037 104.743 -2.14531 80.0663 5.34016C55.39 12.8256 34.0726 28.6357 19.7463 50.0765C5.41999 71.5174 -1.0288 97.2623 1.49874 122.925C4.02627 148.587 15.3737 172.58 33.6077 190.813L112.421 112L112.421 223.459Z" fill="#E0E0E0"/></svg>'
                ],
                [
                    'title' => '200 GB',
                    'price' => 5,
                    'bg'    => 'bg-step3-300',
                    'icon'  => '<svg viewBox="0 0 224 224" fill="none"<circle cx="112.421" cy="112" r="111.459" fill="white"/><path d="M112.421 223.459C134.466 223.459 156.015 216.922 174.345 204.675C192.674 192.428 206.96 175.02 215.396 154.654C223.832 134.287 226.039 111.876 221.739 90.2553C217.438 68.6344 206.823 48.7742 191.235 33.1864C175.647 17.5986 155.787 6.9831 134.166 2.68242C112.545 -1.61825 90.1341 0.589009 69.7676 9.02509C49.4011 17.4612 31.9936 31.7472 19.7463 50.0765C7.499 68.4059 0.962032 89.9554 0.962031 112L112.421 112L112.421 223.459Z" fill="#E0E0E0"/></svg>'
                ], [
                    'title' => 'Unlimited',
                    'price' => 10,
                    'bg'    => 'bg-step3-400',
                    'icon'  => '<svg viewBox="0 0 41 22" fill="none"><path d="M20.1558 6.97294C21.2558 5.87294 22.2558 4.87294 23.1558 3.87294C24.4558 2.57294 25.8558 1.47294 27.5558 1.07294C30.8558 0.172944 33.8558 0.672944 36.5558 2.97294C39.4558 5.47294 40.6558 8.77294 40.1558 12.5729C39.5558 16.7729 37.2558 19.6729 33.3558 21.0729C30.2558 22.1729 27.2558 21.6729 24.6558 19.5729C23.3558 18.5729 22.2558 17.2729 21.0558 16.0729C20.7558 15.7729 20.5558 15.5729 20.2558 15.2729C19.5558 15.9729 18.8558 16.6729 18.2558 17.3729C17.4558 18.0729 16.7558 18.8729 15.9558 19.5729C14.1558 20.9729 12.1558 21.5729 9.95575 21.5729C7.75575 21.4729 5.75575 20.7729 4.05575 19.2729C1.25575 16.7729 -0.0442463 13.5729 0.455754 9.67294C0.955754 5.87294 2.95575 3.07294 6.25575 1.57294C9.65575 -0.0270565 12.9558 0.372943 15.9558 2.67294C17.2558 3.67294 18.3558 4.97294 19.5558 6.07294C19.6558 6.37294 19.8558 6.67294 20.1558 6.97294ZM16.0558 11.1729C15.0558 10.1729 14.1558 9.17294 13.1558 8.17294C12.9558 7.97294 12.8558 7.87294 12.6558 7.67294C11.7558 6.87294 10.6558 6.57294 9.45575 6.77294C7.75575 6.97294 6.25575 8.37294 5.95575 10.2729C5.55575 12.0729 6.35575 13.9729 7.85575 14.8729C9.35575 15.7729 11.4558 15.6729 12.6558 14.4729C13.8558 13.4729 14.9558 12.2729 16.0558 11.1729ZM24.2558 11.0729C25.3558 12.1729 26.3558 13.2729 27.4558 14.2729C28.7558 15.5729 30.3558 15.8729 32.0558 15.0729C33.6558 14.3729 34.4558 13.0729 34.5558 11.2729C34.6558 9.47294 33.9558 8.07294 32.4558 7.27294C30.9558 6.47294 29.3558 6.47294 28.0558 7.57294C26.6558 8.57294 25.5558 9.87294 24.2558 11.0729Z" fill="white"/></svg>'
                ]
            ],
            'contractLengthVariants' => [
                [
                    'title'      => '18 months',
                    'term'       => 18,
                    'price'      => 0,
                    'freeModem'  => false,
                    'modemPrice' => 99,
                    'value'      => 'FREE Activation',
                    'bg'         => 'bg-blue-200',
                ], [
                    'title'      => '12 months',
                    'term'       => 12,
                    'price'      => 99,
                    'freeModem'  => false,
                    'modemPrice' => 59,
                    'value'      => '$59 Activation',
                    'bg'         => 'bg-blue-300',
                ], [
                    'title'      => 'No lock-in',
                    'term'       => 1,
                    'price'      => 0,
                    'modemPrice' => 109,
                    'freeModem'  => false,
                    'value'      => 'FREE Activation',
                    'bg'         => 'bg-blue-400',
                ]
            ],
            'extraList'              => [
                [
                    'title'      => 'VoIP Phone',
                    'price'      => 10,
                    'selected'   => false,
                    'text1'      => '<p>Unlimited Calls</p><ul><li> -Local & amp; National Calls,</li><li> -13 / 1300 Calls,</li><li> -Calls to Au Mobiles </li></ul></div>',
                    'text2'      => '<p>Plus: </p><ul><li>- Line Rental</li><li>- Great <a class="nbn-alphaphone-intrates">International Calls Rates</a></li></ul>',
                    'bg'         => 'bg-orange-300',
                    'icon'       => '<svg viewBox="0 0 41 34" fill="none"><path d="M21.9 0.300049C23.6 0.600049 25.2 0.800049 26.9 1.10005C31.7 2.20005 35.9 4.40005 39.6 7.70005C39.8 7.80005 39.9 8.00005 40.1 8.20005C40.1 8.20005 40.1 8.30005 40.1 8.20005C38.9 9.40005 37.8 10.6 36.5 11.9C31.9 7.60005 26.4 5.40005 20 5.40005C13.7 5.40005 8.2 7.60005 3.5 12C2.4 10.8 1.2 9.60005 0 8.30005C0.6 7.80005 1.3 7.10005 2 6.50005C6.6 2.90005 11.8 0.800048 17.7 0.400048C17.9 0.400048 18.1 0.300049 18.2 0.300049C19.5 0.300049 20.7 0.300049 21.9 0.300049Z" fill="white"/><path d="M19.3 33.7C18.2 33.4 17.2 33 16.3 32.1C14.7 30.4 14.4 27.9 15.6 25.9C16.8 23.9 19.2 22.9 21.4 23.6C23.7 24.2 25.2 26.3 25.1 28.8C25 31 23.4 33.1 21.2 33.6C21 33.6 20.8 33.7 20.7 33.8C20.2 33.7 19.8 33.7 19.3 33.7Z" fill="white"/><path d="M34.5 13.8C33.3 15 32.1 16.2 30.9 17.4C27.9 14.6 24.2 13.1 20 13.2C15.8 13.2 12.2 14.7 9.09998 17.6C7.89998 16.4 6.69998 15.2 5.59998 14C13.3 6.2 26.7 6.2 34.5 13.8Z" fill="white"/><path d="M25.5 22.8001C22.1 19.9001 17.9 19.9001 14.5 22.8001C13.4 21.6001 12.3 20.5001 11.2 19.3001C14.8 15.1001 23.6 14.0001 29 19.3001C27.8 20.5001 26.7 21.6001 25.5 22.8001Z" fill="white"/></svg>',
                    'variations' => [
                        'payg' => [
                            'title' => 'Pay As You Go Calls',
                            'price' => 0
                        ],
                        'unlimited'     => [
                            'title' => 'Unlimited Calls',
                            'price' => 10
                        ],
                    ]
                ], [
                    'title'    => 'WiFi Modem',
                    'price'    => 59,
                    'selected' => false,
                    'bg'       => 'bg-orange-400',
                    'text1'    => '<p>Features: </p><ul><li> -nbn™ ready, allowing you to connect using all current technologies </li><li> -Preconfigured for data & amp; voice </li></ul> ',
                    'text2'    => '<ul><li> -3 - in - 1 wireless gateway </li><li> -Fast Wifi, VoIP enabled </li></ul> ',
                    'icon'     => '<svg x="0px" y="0px" viewBox = "0 0 299 299" fill="#fff"><path d="M291.333,197.526H162v-105c0-6.627-5.373-12-12-12s-12,5.373-12,12v105H8.333c-4.418,0-8.333,3.582-8.333,8v77c0,4.418,3.915,8,8.333,8h283c4.418,0,7.667-3.582,7.667-8v-77C299,201.108,295.751,197.526,291.333,197.526z M50.833,260.026c-8.837,0-16-7.163-16-16s7.163-16,16-16c8.837,0,16,7.163,16,16S59.67,260.026,50.833,260.026z M98.833,260.026c-8.837,0-16-7.163-16-16s7.163-16,16-16c8.837,0,16,7.163,16,16S107.67,260.026,98.833,260.026z M249.333,260.526h-99c-8.837,0-16-7.163-16-16c0-4.841,2.158-9.17,5.556-12.104c2.804-2.422,6.448-3.896,10.444-3.896h99c8.837,0,16,7.163,16,16S258.17,260.526,249.333,260.526z" /><path d = "M257.611,90.859c0,23.383-9.105,45.365-25.641,61.899c-4.687,4.686-4.687,12.284,0,16.971c2.343,2.343,5.414,3.515,8.485,3.515c3.07,0,6.143-1.172,8.485-3.515c21.067-21.066,32.67-49.077,32.67-78.8c0-29.794-11.603-57.805-32.67-78.871c-4.688-4.685-12.285-4.685-16.971,0c-4.687,4.687-4.687,12.284,0,16.971C248.506,45.493,257.611,67.475,257.611,90.859z" /><path d = "M201.197,143.528c2.343,2.343,5.414,3.515,8.485,3.515c3.07,0,6.142-1.172,8.485-3.515c14.068-14.068,21.817-32.773,21.817-52.669c0-19.896-7.749-38.603-21.817-52.67c-4.688-4.688-12.285-4.686-16.971,0c-4.687,4.687-4.687,12.285,0,16.971c9.536,9.535,14.788,22.213,14.788,35.699c0,13.485-5.252,26.163-14.788,35.698C196.511,131.243,196.511,138.842,201.197,143.528z" /><path d = "M59.544,173.244c3.071,0,6.143-1.172,8.485-3.515c4.686-4.687,4.686-12.285,0-16.971c-16.535-16.534-25.641-38.517-25.641-61.899c0-23.384,9.105-45.366,25.641-61.9c4.686-4.686,4.686-12.284,0-16.971c-4.686-4.685-12.285-4.685-16.971,0c-21.067,21.066-32.67,49.077-32.67,78.871c0,29.793,11.602,57.804,32.67,78.87C53.402,172.072,56.473,173.244,59.544,173.244z" /><path d = "M81.832,143.528c2.344,2.344,5.414,3.515,8.485,3.515c3.071,0,6.143-1.172,8.485-3.515c4.687-4.687,4.687-12.285,0-16.971c-9.536-9.535-14.788-22.213-14.788-35.698c0-13.486,5.252-26.164,14.788-35.699c4.687-4.686,4.687-12.284,0-16.971c-4.685-4.685-12.283-4.687-16.971,0c-14.068,14.067-21.817,32.773-21.817,52.67C60.015,110.755,67.764,129.46,81.832,143.528z"/></svg>'
                ]
            ]
        ]);
    }

    public function saveStep1(Request $request)
    {

        $referenceNumber = $request->input('referenceNumber') ?? null;

        $voipPhonePlan = $request->input('voipPhonePlan') ?? null;
        $isVoIPPhoneSelected = $request->input('phoneServiceSelected') === 'yes' ? true : false;
        if (!$isVoIPPhoneSelected) {
            $voipPhonePlan = null;
        }

        $websiteOrderCart = WebsiteOrderCart::updateOrCreate(
            ['id' =>  $referenceNumber],
            [
                'site_code' => config('services.site.code'),
                'first_name' => $request->input('firstName') ?? null,
                'last_name' => $request->input('lastName') ?? null,
                'phone_number' => $request->input('phoneNumber') ?? null,
                'email' => $request->input('email') ?? null,
                'address' => $request->input('address') ?? null,
                'location_id' => $request->input('directoryId') ?? null,
                'service_type' => 'nbn',
                'plan_name' => $request->input('serviceName') ?? null,
                'connection_type' => $request->input('serviceType') ?? null,
                'monthly_data' => $request->input('monthlyData') ?? null,
                'is_alpha_phone' => $isVoIPPhoneSelected,
                'alpha_phone_plan' => $voipPhonePlan,
                'international_call_pack' => null,
                'is_modem' => $request->input('isWifiModemSelected') ?? null,
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

        if ($websiteOrderCart) {
            $websiteOrderCart->order_submitted = true;
        }

        $serviceOrder = $this->createServiceOrder($request);

        $response = $this->createOrderAddress($serviceOrder, $request);

        $broadbandServiceOrder = $this->createBroadbandServiceOrder($serviceOrder, $request);

        $nbnMinimumMonthlyCost = $broadbandServiceOrder->min_monthly_cost;

        $serviceQualification = $this->createServiceQualification($broadbandServiceOrder->id, $request);

        $isVoIPPhoneSelected = $request->input('phoneServiceSelected') === 'yes' ? true : false;

        $voiceServiceOrder = null;

        $voiceMinimumMonthlyCost = 0;

        if ($isVoIPPhoneSelected === true) {
            $voiceServiceOrder = $this->createVoiceServiceOrder($serviceOrder, $request, 2);
            $voiceMinimumMonthlyCost = $voiceServiceOrder->min_monthly_cost;
        }

        $totalUpfrontCharge = $request->input('totalUpfrontCost') ?? 0;

        $serviceOrder->total_minimum_cost = $nbnMinimumMonthlyCost + $voiceMinimumMonthlyCost + $broadbandServiceOrder->new_cpi_charge + $totalUpfrontCharge;

        $serviceOrder->monthly_cost = $nbnMinimumMonthlyCost + $voiceMinimumMonthlyCost;

        $serviceOrder->total_upfront_charge = $totalUpfrontCharge;

        $serviceOrder->save();

        if ($websiteOrderCart) {
            $websiteOrderCart->order_reference = $serviceOrder->order_reference;
            $websiteOrderCart->save();
        }


        // Send Email
        $siteCode = strtoupper($serviceOrder->site_code);

        $metwideCompany = MetwideCompany::where('code', $siteCode)->first();

        Mail::to($serviceOrder->email)
            ->bcc('adam@itango.com.au')
            ->send(new ConfirmNBNOrder($serviceOrder, $broadbandServiceOrder, $voiceServiceOrder, $metwideCompany));

        return response()->json([
            'status'         => 'success',
            'orderReference' => $serviceOrder->order_reference
        ]);
    }

}
