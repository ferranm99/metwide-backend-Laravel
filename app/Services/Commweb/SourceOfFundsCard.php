<?php

namespace App\Services\Commweb;

/**
 * Card source of funds class
 */
class SourceOfFundsCard extends SourceOfFunds {

	/**
     * @var string Type of funds source
     */
	protected $type = "CARD";

	/**
     * @var Card Card as funds source
     */
	private $card;

	/**
	 * Class constructor
	 *
	 * @param App\Helpers\Commweb\Card $card
	 */
	public function __construct(Card $card) {

		if ( ! empty($card) ) {
			$this->setCard($card);
		}
	}

	/**
	 * Sets card for the source of funds = 'CARD'
	 *
	 * @param Card $card
	 *
	 * @return SourceOfFunds
	 */
	public function setCard(Card $card) {

		$this->card = $card;

		return $this;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		return [
			"type" => $this->type,
			"provided" => [
				"card" => $this->card
			]
		];
	}
}

