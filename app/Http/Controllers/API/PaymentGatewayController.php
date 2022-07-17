<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Controllers\API\SmileController;

use App\Helpers\GetCreditCardType;

use App\Models\CbaToken;

use App\Helpers\Actions\RequestCBAToken;
use App\Models\CreditCardPayment;
use App\Services\Commweb\Card;
use App\Services\Commweb\Order;
use App\Services\Commweb\PayRequest;
use App\Services\Commweb\SourceOfFundsCard;
use App\Services\Commweb\Transaction;
use DateTime;
use DateTimeZone;

class PaymentGatewayController extends Controller
{

    public function generateToken(Request $request)
    {

        $smileController = new SmileController();

        $ucn = $request->get('ucn');

        $accountName = $request->get('accountName');

        $userName = $request->get('userName');

        $creditCardNumber = $request->get('creditCardNumber');
        $cvc = $request->get('cvc');
        $expiryDate = $request->get('expiryDate');
        $expiry_month = substr($expiryDate, 0, 2);
        $expiry_year = substr($expiryDate, 3, 2);

        $accountType = 'MWC';

        $creditType = GetCreditCardType::execute($creditCardNumber);

        if ($creditType === 'amex') {
            $paymentType = $accountType . '-CBA-Amex-Token';
        } else {
            $paymentType = $accountType . '-CBA-Token';
        }

        $token = RequestCBAToken::execute($creditCardNumber, $expiryDate, $accountType);

        $cbaToken = CbaToken::create(
            [
                'account_ucn' => $ucn,
                'token' => $token,
                'payment_type' => $paymentType,
                'account_name' => $accountName,
                'account_type' => $accountType,
                'last_four_digits' => substr($creditCardNumber, -4),
                'generated_by' => $userName,
            ]
        );

        return response()->json('success');
    }

    public function processCreditCardPayment(Request $request)
    {

        $ucn = $request->get('ucn');
        $amount = $request->get('amount');
        $creditCardNumber = $request->get('creditCardNumber');
        $cvc = $request->get('cvc');

        $ccPay = CreditCardPayment::where('account_ucn', $ucn)->where('result', 'PROCESSING')->first();

        if ($ccPay) {
            return response()->json(
                ['status' => 'processing']
            );
        }

        $amount = number_format((float) $amount, 2, '.', '');

        $orderId = time() . '' . rand(0, 9);

        $transactionId = 'TXD1';

        $smileController = new SmileController();

        $accountType = 'MWC';

        $expiry = $request->get('expiryDate');
        $expiryMonth = substr($expiry, 0, 2);
        $expiryYear = substr($expiry, 3, 2);

        $creditType = GetCreditCardType::execute($creditCardNumber);


        if ($creditType === 'amex') {
            $paymentType = $accountType . '-CBA-Amex';
            $surchargePercentage = 2;
        } else {
            $paymentType = $accountType . '-CBA-Credit-Card';
            $surchargePercentage = 1.5;
        }

        $surcharge = $amount * ($surchargePercentage / 100) * 1.1;
        $surcharge = round(ceil($surcharge * 100) / 100, 2);

        //  $surcharge = number_format($surcharge, 2, '.', '');

        $chargeAmount = $amount + $surcharge;
        $chargeAmount = sprintf('%0.2f', $chargeAmount);


        $creditCardPayment = CreditCardPayment::create([
            'account_ucn' => $ucn,
            'amount' => $amount,
            'surcharge' => $surcharge,
            'order_id' => $orderId,
            'transaction_id' => $transactionId,
            'transaction_type' => 'PAYMENT',
            'result' => 'PROCESSING',
            'payment_type' => $paymentType,
            'processed_by' => $request->get('processedBy'),
        ]);



        $merchantId = config('services.commweb.' . strtolower($accountType) . '.merchantid');
        $password = config('services.commweb.' . strtolower($accountType) . '.password');

       // return response()->json('merchantId - ' . $chargeAmount);

        $response = (new PayRequest($merchantId))
            ->setApiPassword($password)
            ->setOrder(new Order($orderId, $chargeAmount, "AUD"))
            ->setTransaction(new Transaction($transactionId))
            ->setSourceOfFunds(new SourceOfFundsCard(new Card($creditCardNumber, $expiryMonth, $expiryYear, $cvc)))
            ->send();

        if ($response->result === 'ERROR') {
            $creditCardPayment->result = 'ERROR';
            $creditCardPayment->error_cause = $response->error->cause ?? null;
            $creditCardPayment->error_explanation = $response->error->explanation ?? null;
            $creditCardPayment->error_field = $response->error->field ?? null;
            $creditCardPayment->error_validation_type = $response->error->validationType ?? null;
            $creditCardPayment->save();

            return response()->json([
                'status' => 'error processing'
            ]);
        }

        if ($response->result === 'FAILURE') {
            $creditCardPayment->result = 'FAILURE';
            $creditCardPayment->acquirer_message = $response->response->acquirerMessage;
            $creditCardPayment->save();

            return response()->json(
                [
                    'status' => 'payment failed',
                    'bankResponse' => strtoupper($response->response->acquirerMessage)
                ]
            );
        }

        if ($response->result === 'SUCCESS') {

            $processDateTime = $response->timeOfRecord;

            $processDateTime = new DateTime($processDateTime);
            $processDateTime->setTimezone(new DateTimeZone($response->transaction->acquirer->timeZone));

            $processDate = $processDateTime->format('Y-m-d');
            $processTime = $processDateTime->format('H:i:s');

            $creditCardPayment->transaction_type = 'PAYMENT';
            $creditCardPayment->source_of_funds = 'CARD';
            $creditCardPayment->captured_amount = $response->order->totalCapturedAmount ?? null;
            $creditCardPayment->result = $response->result ?? null;
            $creditCardPayment->acquirer_message = $response->response->acquirerMessage ?? null;
            $creditCardPayment->transaction_identifier = $response->authorizationResponse->transactionIdentifier ?? null;
            $creditCardPayment->receipt = $response->transaction->receipt ?? null;
            $creditCardPayment->authorization_code = $response->transaction->authorizationCode ?? null;
            $creditCardPayment->response_gateway_code = $response->response->gatewayCode ?? null;
            $creditCardPayment->date_payment_processed = $processDate ?? null;
            $creditCardPayment->time_payment_processed = $processTime ?? null;
            $creditCardPayment->timestamp = $response->timeOfRecord ?? null;
            $creditCardPayment->smile_status = 'UPLOAD TO SMILE';
            $creditCardPayment->save();

            // $response = $this->storeBatchExport($creditCardPayment->id, strtoupper($accountType), $processDateTime);

            return response()->json(
                [
                    'status' => 'success',
                    'receipt' => $response->transaction->receipt ?? null
                ]
            );
        }

        // return Action::message(__('Payment was successfully processed.'));
    }

    private function getCreditCardType($str, $format = 'string')
    {
        if (empty($str)) {
            return false;
        }

        $matchingPatterns = [
            'visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'mastercard' => '/^5[1-5][0-9]{14}$/',
            'amex' => '/^3[47][0-9]{13}$/',
            'diners' => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
            'discover' => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
            'jcb' => '/^(?:2131|1800|35\d{3})\d{11}$/',
            'any' => '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/'
        ];

        $ctr = 1;
        foreach ($matchingPatterns as $key => $pattern) {
            if (preg_match($pattern, $str)) {
                return $format == 'string' ? $key : $ctr;
            }
            $ctr++;
        }
    }
}
