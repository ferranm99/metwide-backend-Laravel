<?php

namespace App\Services\Commweb;

/**
 * An abstract source of funds class
 */
abstract class SourceOfFunds implements \JsonSerializable {

	/**
     * @var string Type of funds source
     */
	protected $type;

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		return [
			"type" => $this->type
		];
	}
}
