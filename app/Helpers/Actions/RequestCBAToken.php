<?php

namespace App\Helpers\Actions;

use App\Services\Commweb\TokenRequest;
use App\Services\Commweb\SourceOfFundsCard;
use App\Services\Commweb\Card;

use GetCreditCardType;

class RequestCBAToken
{

    public static function execute($creditCardNumber, $expiry, $accountType)
    {
        $expiryMonth = substr($expiry, 0, 2);
        $expiryYear = substr($expiry, 3, 2);

        $accountType = strtolower($accountType);

        $merchantId = config('services.commweb.' . $accountType . '.merchantid');
        $password = config('services.commweb.' . $accountType . '.password');

        $response = (new TokenRequest($merchantId))
            ->setApiPassword($password)
            ->setSourceOfFunds(
                new SourceOfFundsCard(
                    new Card(
                        $creditCardNumber,
                        $expiryMonth,
                        $expiryYear
                    )
                )
            )
            ->send();

        $cbaToken= $response->token;

        return $cbaToken;
    }
}
