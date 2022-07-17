<?php

namespace App\Services\Commweb;

/**
 * A class to init the transaction
 */
class TokenRequest extends RequestAbstract {

    protected $method = 'POST';

    protected $isTokenRequest = true;

	/**
     * @var App\Services\Commweb\SourceOfFundsCard Source of funds for the transaction
     *
     */
	private $sourceOfFundsCard;

	/**
	 * Sets source of funds of request
	 *
	 * @param App\Services\Commweb\SourceOfFundsCard $sourceOfFundsCard
	 *
	 * @return App\Services\Commweb\TokenRequest
	 */
	public function setSourceOfFunds(SourceOfFundsCard $sourceOfFundsCard) {

        $this->sourceOfFunds = $sourceOfFundsCard;

		return $this;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"sourceOfFunds" => $this->sourceOfFunds
		];

		return $result;
	}
}
