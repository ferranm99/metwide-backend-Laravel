<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\AccountSubscription;
use App\Models\AccountTransaction;
use App\Models\BroadbandServiceOrder;
use App\Models\VocusNbnOutageRecord;
use App\Models\VocusDailyStatusReport;
use Illuminate\Support\Facades\DB;

use App\Actions\Smile\UserOnlineStatus;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\DataServiceModification;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class BackOfficeController extends Controller
{
    public function checkAccountExists(Request $request)
    {
        $ucn = $request->get('ucn');

        $accountSubscription = AccountSubscription::where('account_ucn', $ucn)->where('is_broadband', true)->first();

        return $accountSubscription != null ? 'SUCCESS' : 'FAIL';
    }


    public function getBroadbandOrders(Request $request)
    {
        $ucn = $request->get('ucn');

        $customers = Account::where('reseller_ucn', $ucn)->get()->pluck('ucn')->toArray();

        array_push($customers, $ucn);

        $orders = BroadbandServiceOrder::with("serviceOrder", "vocusServiceOrders", "subscription", "dataPlan")
            ->whereHas('serviceOrder', function ($q) use ($customers) {
                $q->whereIn('account_ucn', $customers);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($orders);
    }


    public function getBroadbandOrdersStatus(Request $request)
    {
        $ucn = $request->get('ucn');

        $orders = BroadbandServiceOrder::whereHas('serviceOrder', function ($q) use ($ucn) {
            $q->where('account_ucn', $ucn);
        })
            ->get();

        $active = $orders->countBy('provisioning_status');

        return response()->json($active);
    }

    public function getBroadbandOrder(Request $request)
    {
        $orderReference = $request->get('orderReference');

        $order = BroadbandServiceOrder::with(
            "vocusServiceOrders",
            "vocusServiceOrders.vocusAppointments",
            "vocusServiceOrders.vocusAppointments.vocusAppointmentRecords",
            "vocusServiceOrders.vocusOrderConversations",
            "subscription",
            "dataPlan",
            "serviceQualifications",
            "supportPackagePlan"
        )
            ->where('service_order_reference', $orderReference)
            ->first();

        return response()->json($order);
    }

    public function getNbnServices(Request $request)
    {
        $ucn = $request->get('ucn');

        $services = DB::table('vocus_daily_status_reports')
            ->join('account_subscriptions', 'account_subscriptions.usn', '=', 'vocus_daily_status_reports.subscription_usn')
            ->join('accounts', 'accounts.ucn', '=', 'account_subscriptions.account_ucn')
            ->join('vocus_nbn_plan_ids', 'vocus_nbn_plan_ids.fibre_plan_id', '=', 'vocus_daily_status_reports.plan_id')
            ->select('accounts.ucn', 'accounts.name', 'accounts.contact_given', 'accounts.contact_family', 'vocus_daily_status_reports.id', 'account_subscriptions.username', 'vocus_daily_status_reports.status', 'vocus_nbn_plan_ids.line_speed', 'vocus_daily_status_reports.service_type', 'vocus_daily_status_reports.directory_id', 'vocus_daily_status_reports.address')
            ->where('accounts.ucn', $ucn)
            ->orWhere('accounts.reseller_ucn', $ucn)
            ->get();

        foreach ($services as $key => $service) {
            $status = UserOnlineStatus::get($service->username);
            if (count($status) > 0) {
                $onlineStatus = $status[0];
                $service->starttime = $onlineStatus['starttime'];
                $service->seconds = $onlineStatus['seconds'];
                $service->assignedaddress = $onlineStatus['assignedaddress'];
            }
        }

        return response()->json($services);
    }

    public function getNbnService(Request $request)
    {
        $username = $request->get('username');

        $service = DB::table('vocus_daily_status_reports')
            ->join('account_subscriptions', 'account_subscriptions.usn', '=', 'vocus_daily_status_reports.subscription_usn')
            ->join('accounts', 'accounts.ucn', '=', 'account_subscriptions.account_ucn')
            ->join('vocus_nbn_plan_ids', 'vocus_nbn_plan_ids.fibre_plan_id', '=', 'vocus_daily_status_reports.plan_id')
            ->select('account_subscriptions.username', 'account_subscriptions.usn', 'vocus_daily_status_reports.status', 'vocus_nbn_plan_ids.line_speed', 'vocus_daily_status_reports.service_type', 'vocus_daily_status_reports.directory_id', 'vocus_daily_status_reports.address', 'vocus_daily_status_reports.ctag', 'vocus_daily_status_reports.ntd_id', 'vocus_daily_status_reports.data_port_id')
            ->where('account_subscriptions.username', $username)
            ->first();

        if ($service) {
            $status = UserOnlineStatus::get($service->username);
            if (count($status) > 0) {
                $onlineStatus = $status[0];
                $service->starttime = $onlineStatus['starttime'];
                $service->seconds = $onlineStatus['seconds'];
                $service->assignedaddress = $onlineStatus['assignedaddress'];
            }
        }

        return response()->json($service);
    }

    public function getNbnServicesStatus(Request $request)
    {
        $ucn = $request->get('ucn');

        $orders = VocusDailyStatusReport::whereHas('subscription', function ($q) use ($ucn) {
            $q->where('account_ucn', $ucn);
        })
            ->get();

        $active = $orders->countBy('status');

        return response()->json($active);
    }

    public function getSubscriptions(Request $request)
    {
        $ucn = $request->get('ucn');

        $subs = AccountSubscription::with("account", "smilePlan")
            ->whereHas('account', function ($q) use ($ucn) {
                $q->where('reseller_ucn', $ucn);
            })
            ->orwhere('account_ucn', $ucn)
            ->orderBy('usn')
            ->get();

        return response()->json($subs);
    }

    public function getSubscription(Request $request)
    {
        $usn = $request->get('usn');

        $subscription = AccountSubscription::with("smilePlan")->where('usn', $usn)
            ->first();

        return response()->json($subscription);
    }

    public function getNetworkStatuses(Request $request)
    {
        $ucn = $request->get('ucn');

        $services = DB::table('vocus_nbn_outage_records')
            ->join('vocus_daily_status_reports', 'vocus_nbn_outage_records.vocus_service_id', '=', 'vocus_daily_status_reports.id')
            ->join('account_subscriptions', 'account_subscriptions.usn', '=', 'vocus_daily_status_reports.subscription_usn')
            ->join('accounts', 'accounts.ucn', '=', 'account_subscriptions.account_ucn')
            ->select('accounts.ucn', 'accounts.name', 'accounts.contact_given', 'accounts.contact_family', 'vocus_daily_status_reports.username', 'vocus_nbn_outage_records.*',)
            ->where('accounts.ucn', $ucn)
            ->orWhere('accounts.reseller_ucn', $ucn)
            ->orderBy('vocus_nbn_outage_records.created_at', 'desc')
            ->get();

        return response()->json($services);
    }

    public function getNetworkStatus(Request $request)
    {
        $eventID = $request->get('eventID');

        $networkStatus = VocusNbnOutageRecord::with("vocusService")->where('event_id', $eventID)
            ->first();

        return response()->json($networkStatus);
    }

    public function getInvoices(Request $request)
    {
        $ucn = $request->get('ucn');

        $invoices = DB::table('account_transactions')
            ->join('accounts', 'accounts.ucn', '=', 'account_transactions.account_ucn')
            ->select('accounts.ucn', 'accounts.name', 'accounts.contact_given', 'accounts.contact_family', 'account_transactions.*',)
            ->where(function ($q) use ($ucn) {
                $q->where('accounts.reseller_ucn', $ucn)->orwhere('accounts.ucn', $ucn);
            })
            ->where('account_transactions.transaction_type', 'Invoice')
            ->orderBy('account_transactions.entry_date', 'desc')
            ->get();

        return response()->json($invoices);
    }

    public function getTransactions(Request $request)
    {
        $ucn = $request->get('ucn');


        $transactions = DB::table('account_transactions')
            ->join('accounts', 'accounts.ucn', '=', 'account_transactions.account_ucn')
            ->select('accounts.ucn', 'accounts.name', 'accounts.contact_given', 'accounts.contact_family', 'account_transactions.*',)
            ->where(function ($q) use ($ucn) {
                $q->where('accounts.reseller_ucn', $ucn)->orwhere('accounts.ucn', $ucn);
            })
            ->where('account_transactions.transaction_type', '!=', 'Invoice')
            ->orderBy('account_transactions.entry_date', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function getAccount(Request $request)
    {
        $ucn = $request->get('ucn');

        $account = Account::where('ucn', $ucn)
            ->get();

        return response()->json($account);
    }

    public function getAccountUsers(Request $request)
    {
        $ucn = $request->get('ucn');

        $accountUsers = AccountUser::where('account_ucn', $ucn)
            ->get();

        return response()->json($accountUsers);
    }

    public function getAccountCustomers(Request $request)
    {
        $ucn = $request->get('ucn');

        $accountUsers = Account::where('reseller_ucn', $ucn)
            ->get();

        return response()->json($accountUsers);
    }

    public function getAccountCustomer(Request $request)
    {
        $ucn = $request->get('ucn');

        $accountUser = Account::where('ucn', $ucn)
            ->first();

        return response()->json($accountUser);
    }



    public function addAccountUser(Request $request)
    {
        $user = $request->all();

        $accountUser = AccountUser::where('email', $user['email'])
            ->where('account_ucn', $user['ucn'])
            ->first();

        if ($accountUser) {
            return response()->json('Exists');
        }

        $account = AccountUser::create([
            'account_ucn' => $user['ucn'],
            'first_name' => $user['firstName'],
            'last_name' => $user['lastName'],
            'position' => $user['position'],
            'email' => $user['email'],
            'phone_number' => $user['phoneNumber'],
            'mobile_number' => $user['mobileNumber'],
            'password' => Hash::make($user['password']),
        ]);

        return response()->json('OK');
    }

    public function speedChangeRequest(Request $request)
    {
        $speedChange = $request->all();

        // return response()->json($speedChange);
        $dataServiceModification = DataServiceModification::where('vocus_service_id', $speedChange['vocusServiceID'])
            ->where(function ($q) {
                $q->where('provisioning_status', 'In Progress')
                    ->orWhere('provisioning_status', 'New Order');
            })
            ->first();

        if ($dataServiceModification) {
            return response()->json(['status' => 'InProgress']);
        }

        $serviceOrder = $this->createServiceOrderPortal($request);

        $response = $this->createDataServiceModification($serviceOrder, $request);

        return response()->json(['status' => 'success']);
    }

}
