<?php

namespace App\Services\Commweb;

/**
 * An abstract class to init the transaction
 */
abstract class VerifyRequestAbstract extends RequestAbstract {

	/**
     * @var SourceOfFunds Source of funds for the transaction
     *
     */
	private $sourceOfFunds;

	/**
	 * Sets source of funds of request
	 *
	 * @param SourceOfFunds $sourceOfFunds
	 *
	 * @return PayRequestAbstract
	 */
	public function setSourceOfFunds(SourceOfFunds $sourceOfFunds) {

		$this->sourceOfFunds = $sourceOfFunds;

		return $this;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"apiOperation" => $this->apiOperation,
			"order" => $this->order
		];

		if ( ! empty($this->sourceOfFunds) ) {

			$result["sourceOfFunds"] = $this->sourceOfFunds;
		}

		return $result;
	}
}

