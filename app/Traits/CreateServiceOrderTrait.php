<?php

namespace App\Traits;

use App\Models\ServiceOrder;
use App\Models\Product;
use App\Helpers\GeneratePassword;
use App\Models\Account;

trait CreateServiceOrderTrait
{
    public function createServiceOrder($request)
    {

        $isBusiness = $request->input('accountType') === "Business" ? true : false;

        $idType = $request->input('identificationType') ?? null;
        $idNumber = $request->input('identification') ?? null;
        $positionTitle = $request->input('position') ?? null;

        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');

        $deliveryName = $request->input('deliveryName') ?? null;

        if ($deliveryName === null) {
            $deliveryName = implode(' ', [$firstName, $lastName]);
        }

        $phoneType = $request->input('phoneType') ?? null;

        $contactNumber = $request->input('phoneNumber') ?? null;
        $mobileNumber = null;
        $workNumber = null;

        switch ($phoneType) {
            case 'Work':
                $workNumber = $contactNumber;
                break;
            case 'Mobile':
                $mobileNumber = $contactNumber;
                break;
            case 'Home':
                $homeNumber = $contactNumber;
                break;
            default:
                break;
        }

        if ($isBusiness) {
            $idType = null;
            $idNumber = null;
        } else {
            $positionTitle = null;
        }

        $isModemOrdered = $request->input('modemSelected') === "yes" ? true : false;

        $modemModelId = null;
        if ($isModemOrdered) {
            $modemModelId = $this->getModemModel($request->input('selectedModemModel'));
        }

        $serviceOrder = ServiceOrder::create([
            'account_ucn' => $request->input('ucn') ?? null,
            'order_reference' => null,
            'provisioning_status' => 'New Order',
            'title' => $request->input('title') ?? null,
            'first_name' => $request->input('firstName') ?? null,
            'last_name' => $request->input('lastName') ?? null,
            'dob' => $this->formatDOB($request->input('birthYear'), $request->input('birthMonth'), $request->input('birthDay')),
            'email' => $request->input('email') ?? null,
            'contact_type' => $phoneType,
            'contact_number' => $contactNumber,
            'contact_mobile_number' => $mobileNumber,
            'contact_work_number' => $workNumber,
            'id_type' => $idType,
            'id_number' => $idNumber,
            'is_business' => $isBusiness,
            'position_title' => $positionTitle,
            'company_name' => $request->input('companyName') ?? null,
            'company_trading_name' => $request->input('tradingName') ?? null,
            'abn' => $request->input('abn') ?? null,
            'submit_date' => now(),
            'referrer_code' => $request->input('referrerCode') ?? null,
            'cc_token' => $request->input('token') ?? null,
            'card_ending' => $request->input('cardEnding') ?? null,
            'credit_card_type' => $request->input('cardType') ?? null,
            'payment_type' => $request->input('cardType') ?? null,
            'is_modem' => $isModemOrdered,
            'modem_cost' => $isModemOrdered ? $request->input('modemCost') : 0,
            'product_id' => $modemModelId,
            'delivery_cost' => $request->input('deliveryCost') ?? 0,
            'monthly_cost' => null,
            'total_minimum_cost' => null,
            'total_upfront_charge' => $request->input('upfrontCosts') ?? 0,
            'username' => $this->getUsername($firstName, $lastName),
            'password' => GeneratePassword::value(12),
            'site_code' => config('services.site.code'),
            'draft_order' => false,
            'delivery_name' => $deliveryName,
            'new_billing_account' => $request->input('newBillingAccount') ?? 0,
            'authenticated_user_submit' => $request->input('authenticatedUserSubmit') ?? 0,
        ]);

        $orderId = $serviceOrder->id;

        $orderReferenceNumber = config('services.site.code') . '-' . str_pad($orderId + 5500, 6, '0', STR_PAD_LEFT);

        $serviceOrder->order_reference = $orderReferenceNumber;

        $serviceOrder->username = $this->getUsername($orderReferenceNumber);

        $serviceOrder->save();

        return $serviceOrder;
    }

    public function createServiceOrderPortal($request)
    {

        $ucn = $request->input('ucn') ?? null;

        $metwideToBill =  $request->input('metwideToBill');

        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');

        $orderType = $request->input('orderType');

        $isModemOrdered = $orderType === 'Modem' ? true : false;
        $modemModelId = null;

        if ($isModemOrdered) {
            $modemModelId = $this->getModemModel($request->input('selectedModemModel'));
        }

        $serviceOrder = ServiceOrder::create([
            'account_ucn' => $request->input('ucn'),
            'new_billing_account' => $request->input('metwideToBill'),
            'order_type' => $request->input('orderType'),
            'provisioning_status' => 'New Order',
            'title' => $request->input('title') ?? null,
            'first_name' => $request->input('firstName') ?? null,
            'last_name' => $request->input('lastName') ?? null,
            'email' => $request->input('email') ?? null,
            'contact_type' => null,
            'contact_number' => $request->input('phoneNumber') ?? null,
            'contact_mobile_number' => $request->input('mobileNumber') ?? null,
            'contact_work_number' => $request->input('workNumber') ?? null,
            'submit_date' => now(),
            'site_code' => config('MWC'),
            'is_modem' => $isModemOrdered,
            'product_id' => $modemModelId,
            'draft_order' => false,
        ]);

        $customerDetails = [];
        if ($metwideToBill) {
            $customerDetails = $this->parseNewCustomerDetails($request);
        } else {
            $customerDetails = $this->parseCustomerDetails($request);
        }

        $serviceOrder = ServiceOrder::create([
            'account_ucn' => $metwideToBill ? null : $ucn,
            'order_reference' => null,
            'provisioning_status' => 'New Order',
            'title' => $request->input('title') ?? null,
            'first_name' => $customerDetails['firstName'],
            'last_name' => $customerDetails['lastName'],
            'dob' =>$customerDetails['dob'],
            'email' => $customerDetails['email'],
            'contact_type' => $customerDetails['contactType'],
            'contact_number' => $customerDetails['firstName'],
            'contact_mobile_number' =>$customerDetails['firstName'],
            'contact_work_number' => $customerDetails['firstName'],
            'id_type' => $customerDetails['firstName'],
            'id_number' => $customerDetails['firstName'],
            'is_business' => $customerDetails['firstName'],
            'position_title' => $customerDetails['firstName'],
            'company_name' => $customerDetails['firstName'],
            'company_trading_name' => $customerDetails['firstName'],
            'abn' => $customerDetails['firstName'],
            'submit_date' => now(),
            'referrer_code' => $request->input('referrerCode') ?? null,
            'cc_token' => $request->input('token') ?? null,
            'card_ending' => $request->input('cardEnding') ?? null,
            'credit_card_type' => $request->input('cardType') ?? null,
            'payment_type' => $request->input('cardType') ?? null,
            'is_modem' => $isModemOrdered,
            'modem_cost' => $isModemOrdered ? $request->input('modemCost') : 0,
            'product_id' => $modemModelId,
            'delivery_cost' => $request->input('deliveryCost') ?? 0,
            'monthly_cost' => null,
            'total_minimum_cost' => null,
            'total_upfront_charge' => $request->input('upfrontCosts') ?? 0,
            'username' => $this->getUsername($firstName, $lastName),
            'password' => GeneratePassword::value(12),
            'site_code' => config('services.site.code'),
            'draft_order' => false,
            'delivery_name' => null,
            'new_billing_account' => $metwideToBill,
            'authenticated_user_submit' => true,
        ]);

        $orderId = $serviceOrder->id;

        $orderReferenceNumber = 'MWC' . '-' . str_pad($orderId + 5500, 6, '0', STR_PAD_LEFT);

        $serviceOrder->order_reference = $orderReferenceNumber;

        $serviceOrder->save();

        return $serviceOrder;
    }

    private function formatDOB($birthYear, $birthMonth, $birthDay)
    {
        if ($birthYear === null || $birthMonth === null || $birthDay === null) {
            return null;
        }

        $dob = $birthYear . '-' . $birthMonth . '-' . $birthDay;

        return $dob;
    }

    private function getUsername($orderReferenceNumber)
    {

        $username = str_replace('-', '', strtolower($orderReferenceNumber)) . '@nbn.alphacall.com.au';

        return $username;
    }

    private function getModemModel($code)
    {

        $product = Product::where('code', $code)->first();

        return $product->id ?? null;
    }

    private function parseCustomerDetails($request)
    {
        $customerDetails = [];

        $ucn = $request->input('ucn');

        $account = Account::where('ucn', $ucn)->first();

        $customerDetails['title'] = $request->input('title') ?? null;
        $customerDetails['firstName'] = $request->input('orderContactFirstName') ?? null;
        $customerDetails['lastName'] = $request->input('orderContactLastName') ?? null;
        $customerDetails['dob'] = null;
        $customerDetails['email'] = $request->input('orderContactEmail') ?? null;
        $customerDetails['contactType'] = null;
        $customerDetails['contactNumber'] = $request->input('orderContactPhoneNumber') ?? null;
        $customerDetails['contactMobileNumber'] = $request->input('orderContactMobileNumber') ?? null;
        $customerDetails['contactWorkNumber'] = $account->work_phone ?? null;
        $customerDetails['idType'] = null;
        $customerDetails['idNumber'] = null;
        $customerDetails['isBusiness'] = null;
        $customerDetails['positionTitle'] = null;
        $customerDetails['companyName'] = $account->company_name ?? null;
        $customerDetails['companyTradingName'] = $account->trading_name ?? null;
        $customerDetails['abn'] = $account->abn ?? null;

        return $customerDetails;
    }

    private function parseNewCustomerDetails($request)
    {
        $customerDetails = [];

        $customerDetails['title'] = $request->input('title') ?? null;
        $customerDetails['firstName'] = $request->input('customerContactFirstName') ?? null;
        $customerDetails['lastName'] = $request->input('customerContactLastName') ?? null;
        $customerDetails['dob'] = null;
        $customerDetails['email'] = $request->input('customerContactEmail') ?? null;
        $customerDetails['contactType'] = null;
        $customerDetails['contactNumber'] = $request->input('customerContactPhoneNumber') ?? null;
        $customerDetails['contactMobileNumber'] = $request->input('customerContactMobileNumber') ?? null;
        $customerDetails['contactWorkNumber'] = null;
        $customerDetails['idType'] = null;
        $customerDetails['idNumber'] = null;
        $customerDetails['isBusiness'] = null;
        $customerDetails['positionTitle'] = null;
        $customerDetails['companyName'] = $request->input('customerCompanyName') ?? null;
        $customerDetails['companyTradingName'] = $request->input('customerTradingName') ?? null;
        $customerDetails['abn'] = $request->input('customerABN') ?? null;

        return $customerDetails;
    }
}
