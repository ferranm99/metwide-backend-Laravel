<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Helpers\GetCreditCardType;

use App\Services\Commweb\TokenRequest;
use App\Services\Commweb\SourceOfFundsCard;
use App\Services\Commweb\Card;

class CardController extends Controller
{

    /**
     * Get locationID(s) for the provided address
     *
     * @param Request $request
     *
     * @return Array
     */
    public function generateCardToken(Request $request)
    {

        if (config('services.commweb.token_test') === true) {
            return response()->json([
                'status' => 'VALID',
                'token' => '9463387055725250'
            ]);

            /*
            return response()->json([
                'status' => 'ERROR',
                'error' => 'Card expired. Please, try again.'
            ]);
            */
        }

        $cardNumber = $request->get('cardNumber');
        $cardExpiryMonth = $request->get('cardExpiryMonth');
        $cardExpiryYear = $request->get('cardExpiryYear');
        $cardExpiryYear = (int) $cardExpiryYear - 2000;

        $creditType = GetCreditCardType::execute($cardNumber);

        if ($creditType === 'amex') {
            $paymentType = 'MWC-CBA-Amex-Token';
        } else {
            $paymentType = 'MWC-CBA-Token';
        }

        $accountType = strtolower('MWC');

        $merchantId = config('services.commweb.' . $accountType . '.merchantid');
        $password = config('services.commweb.' . $accountType . '.password');

        $response = (new TokenRequest($merchantId))
            ->setApiPassword($password)
            ->setSourceOfFunds(
                new SourceOfFundsCard(
                    new Card(
                        $cardNumber,
                        $cardExpiryMonth,
                        $cardExpiryYear
                    )
                )
            )
            ->send();

        return response()->json($response);

        $result = $response->result;
        $errorCause = $response->error->cause ?? '';
        $errorExplanation = $response->error->explanation ?? '';
        $creditCardToken = $response->token ?? '';


        return response()->json([
            'status' => $result,
            'token' => $creditCardToken,
            'errorCause' => $errorCause,
            'errorExplanation' => $errorExplanation,
        ]);
    }
}
