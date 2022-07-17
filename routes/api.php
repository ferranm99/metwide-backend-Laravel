<?php

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

//--------------------------------------------------------------------------
// API Routes
//--------------------------------------------------------------------------
//
// Here is where you can register API routes for your application. These
// routes are loaded by the RouteServiceProvider within a group which
// is assigned the "api" middleware group. Enjoy building your API!
//





Route::group(['prefix' => 'v1'], function () {

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        $remapAttrs = [
            'id' => 'au_id',
            'first_name' => 'au_first_name',
            'last_name' => 'au_last_name',
            'position' => 'au_position',
            'account_owner' => 'account_owner',
            'email' => 'au_email',
            'phone_number' => 'au_phone_number',
            'mobile_number' => 'au_mobile_number',
        ];
        $user = $request->user();
        Log::debug($user->account_ucn);
        $account = Account::where('ucn', $user->account_ucn)->first();

        $user = $user->toArray();
        foreach ($remapAttrs as $key => $new_key) {
            if (array_key_exists($key, $user)) {
                $user[$new_key] = $user[$key];
                unset($user[$key]);
            }
        }
        Log::debug($user);
        return response()->json([
            'user' => $user,
            'account' => $account
        ]);
        // return $request->user();

    });

    Route::post('/user/get-account', 'App\\Http\\Controllers\\API\\BusinessNbnDataController@getAccount');

    /**
     * Business nbn routes
     */
    Route::get('/nbn-business-data', 'App\\Http\\Controllers\\API\\BusinessNbnDataController@getNbnData');

    /**
     * Vocus routes
     */
    Route::post('/nbn/get-nbn-location-id', 'App\\Http\\Controllers\\API\\VocusController@getNBNLocationID');
    Route::post('/nbn/get-qualify-location-id', 'App\\Http\\Controllers\\API\\VocusController@qualifyLocationID');

    Route::post('/nbn/ma-get-nbn-location-id', 'App\\Http\\Controllers\\API\\VocusController@myAccountGetNBNLocationID');
    Route::post('/nbn/ma-get-qualify-location-id', 'App\\Http\\Controllers\\API\\VocusController@myAccountQualifyLocationID');


    // Save nbn order
    Route::post('/nbn/save-step-1', 'App\\Http\\Controllers\\API\\NBNController@saveStep1');
    Route::post('/nbn/save-step-2', 'App\\Http\\Controllers\\API\\NBNController@saveStep2');
    Route::post('/nbn/save-order', 'App\\Http\\Controllers\\API\\NBNController@saveOrder');

    // Card
    Route::post('/card/generate-token', 'App\\Http\\Controllers\\API\\CardController@generateCardToken');

    Route::post('/start-conversation', 'App\\Http\\Controllers\\API\\StartConversationController@startConversationRequest');

    Route::post('/request-demo', 'App\\Http\\Controllers\\API\\RequestDemoController@bookDemoRequest');

    Route::post('/get-quote', 'App\\Http\\Controllers\\API\\RequestQuoteController@getQuoteRequest');

    Route::post('/mtv-project-planner-request', 'App\\Http\\Controllers\\API\\ProjectPlannerController@mtvProjectPlannerRequest');

    Route::post('/vc-project-planner-request', 'App\\Http\\Controllers\\API\\ProjectPlannerController@vcProjectPlannerRequest');

    Route::post('/request-it-health-check', 'App\\Http\\Controllers\\API\\RequestITHealthCheckController@bookITHealthCheck');

    Route::post('/infrastructure-audit-request', 'App\\Http\\Controllers\\API\\HardwareAssetManagementController@infrastructureAuditRequest');

    Route::post('/ict-project-planner-request', 'App\\Http\\Controllers\\API\\ProjectPlannerController@ictProjectPlannerRequest');

    Route::post('/wd-project-planner-request', 'App\\Http\\Controllers\\API\\ProjectPlannerController@wdProjectPlannerRequest');

    Route::post('/build-your-server-request', 'App\\Http\\Controllers\\API\\ProjectPlannerController@buildYourServerRequest');

    Route::post('/submit-job-application', 'App\\Http\\Controllers\\API\\JobApplicationController@submitJobApplication');

    Route::post('/submit-case-study-contact', 'App\\Http\\Controllers\\API\\CaseStudyController@submitCaseStudyContact');

    Route::post('/submit-help-centre-form', 'App\\Http\\Controllers\\API\\HelpCentreController@submitHelpCentreForm');

    Route::post('/contact-us-request', 'App\\Http\\Controllers\\API\\ContactUsController@submitContactUsRequest');



    // VoIP International Rates
    Route::get('/voip-phone/get-international-rates/{destination}', 'App\\Http\\Controllers\\API\\VoIPPhoneController@getInternationalRates');

    // Back Office enquiries
    Route::post('/check-account-exists', 'App\\Http\\Controllers\\API\\BackOfficeController@checkAccountExists');

    // SERVICE - VoIP Phone
    Route::post('/voip-phone/save-step-1', 'App\\Http\\Controllers\\API\\VoIPPhoneController@saveStep1');
    Route::post('/voip-phone/save-step-2', 'App\\Http\\Controllers\\API\\VoIPPhoneController@saveStep2');
    Route::post('/voip-phone/save-order', 'App\\Http\\Controllers\\API\\VoIPPhoneController@saveOrder');

    Route::post('/2fa-confirm', 'App\\Http\\Controllers\\Auth\\TwoFactorAuthController@confirm');

    Route::post('/user/update-two-factor-confirmed', 'App\\Http\\Controllers\\Auth\\TwoFactorAuthController@update2FA');

    Route::post('/user/get-broadband-orders', 'App\\Http\\Controllers\\API\\BackOfficeController@getBroadbandOrders');

    Route::post('/user/get-broadband-order', 'App\\Http\\Controllers\\API\\BackOfficeController@getBroadbandOrder');

    Route::post('/user/get-nbn-services', 'App\\Http\\Controllers\\API\\BackOfficeController@getNbnServices');

    Route::post('/user/get-nbn-service', 'App\\Http\\Controllers\\API\\BackOfficeController@getNbnService');

    Route::post('/user/get-subscriptions', 'App\\Http\\Controllers\\API\\BackOfficeController@getSubscriptions');

    Route::post('/user/get-subscription', 'App\\Http\\Controllers\\API\\BackOfficeController@getSubscription');

    Route::post('/user/get-user-online-status', 'App\\Http\\Controllers\\API\\SmileAPIController@getUserOnlineStatus');

    Route::post('/nbn-location-id-lookup', 'App\\Http\\Controllers\\API\\NbnCoAPIController@nbnLocationIDLookup');

    Route::post('/get-nbnco-location-id-address', 'App\\Http\\Controllers\\API\\NbnCoAPIController@getNbnCoLocationIdAddress');

    Route::post('/user/get-network-statuses', 'App\\Http\\Controllers\\API\\BackOfficeController@getNetworkStatuses');

    Route::post('/user/get-network-status', 'App\\Http\\Controllers\\API\\BackOfficeController@getNetworkStatus');

    Route::post('/user/get-network-status', 'App\\Http\\Controllers\\API\\BackOfficeController@getNetworkStatus');

    Route::post('/user/get-invoices', 'App\\Http\\Controllers\\API\\BackOfficeController@getInvoices');

    Route::post('/user/get-transactions', 'App\\Http\\Controllers\\API\\BackOfficeController@getTransactions');

    Route::post('/user/get-broadband-orders-status', 'App\\Http\\Controllers\\API\\BackOfficeController@getBroadbandOrdersStatus');

    Route::post('/user/get-nbn-services-status', 'App\\Http\\Controllers\\API\\BackOfficeController@getNbnServicesStatus');

    Route::post('/user/get-account-users', 'App\\Http\\Controllers\\API\\BackOfficeController@getAccountUsers');

    Route::post('/user/add-account-user', 'App\\Http\\Controllers\\API\\BackOfficeController@addAccountUser');

    Route::post('/user/generate-credit-card-token', 'App\\Http\\Controllers\\API\\PaymentGatewayController@generateToken');

    Route::post('/user/process-payment', 'App\\Http\\Controllers\\API\\PaymentGatewayController@processCreditCardPayment');

    Route::post('/user/speed-change-request', 'App\\Http\\Controllers\\API\\BackOfficeController@speedChangeRequest');

    Route::post('/user/get-account-customers', 'App\\Http\\Controllers\\API\\BackOfficeController@getAccountCustomers');

    Route::post('/user/get-account-customer', 'App\\Http\\Controllers\\API\\BackOfficeController@getAccountCustomer');

    Route::post('/user/submit-modem-order', 'App\\Http\\Controllers\\API\\OrderController@submitModemOrder');

    Route::post('/user/submit-new-order', 'App\\Http\\Controllers\\API\\OrderController@submitNewOrder');
});


$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');
$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post('/v1/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:' . config('fortify.guard'),
        $limiter ? 'throttle:' . $limiter : null,
    ]));
