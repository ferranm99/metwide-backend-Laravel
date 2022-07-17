<?php

namespace App\Services\Commweb;

use Illuminate\Support\Facades\Storage;

/**
 * A class which handles all requests to api
 */
class RetrieveToken {

	/**
     * @var string Request method, can be overriden at child classes if required
     */
    protected $method = 'PUT';

	/**
     * @var string Api version
     */
    private $version = 46;

	/**
     * @var string Api url
     */
    private $url = "https://paymentgateway.commbank.com.au/batch/";

	/**
     * @var string Merchant id
     */
    private $merchant;

	/**
     * @var string Api password
     */
    private $password;

    /**
     * @var string Batch name
     */
    private $batchName;

    /**
     * @var string Batch SHA1
     */
    private $batchSHA1;


	/**
     * @var string|null Error message, empty if no error, some text if any
     */
	private $error;

	/**
	 * Class constructor
	 *
	 * @param string $merchant Merchant id
	 */
	public function __construct($merchant, $password, $batchName) {

        $this->merchant = $merchant;
        $this->password = $password;
        $this->batchName = $batchName;
	}


	/**
	 * Sets api version to request
	 *
	 * @param string $version
     *
	 */
	public function setVersion($version) {

		$this->version = $version;
	}

	/**
	 * Sets api url
	 *
	 * @param string $url
	 *
	 */
	public function setUrl($url) {

        $this->url = $url;

	}

	/**
	 * Sets merchant id
	 *
	 * @param string $merchant Merchant id
	 *
	 */
	public function setMerchant($merchant) {

		if ( substr($merchant, 0, 4) == "TEST" ) {

			$this->setTestMode(true);
			$this->merchant = substr($merchant, 4, strlen($merchant) - 4);
		} else {

			$this->setTestMode(false);
			$this->merchant = $merchant;
		}
	}

	/**
	 * Gets merchant id
	 *
	 * @return string
	 */
	public function getMerchant() {

		return $this->merchant;
	}

	/**
	 * Set api password
	 *
	 * @param string $password
	 *
	 * @return string
	 */
	public function setApiPassword($password) {

        $this->password = $password;

    }

    /**
	 * Set SHA1 for batch content
	 *
	 * @param string $batchSHA1
	 *
	 * @return string
	 */
	public function setBatchSHA1($batchSHA1) {

        $this->batchSHA1 = $batchSHA1;

	}

	/**
	 * Sets test mode
	 *
	 * @param bool $testMode
     *
	 */
	public function setTestMode($testMode) {

		$this->testMode = $testMode;
	}

	/**
	 * Gets test mode
	 *
	 * @return bool
	 */
	public function getTestMode() {

		return $this->testMode;
	}


	/**
	 * Sends request to api
	 *
	 * @return mixed
	 */
	public function send() {

        $batchContents = Storage::disk('cba')->get('export/' . $this->batchName);

        $this->setBatchSHA1( sha1($batchContents) );

        $client = new \GuzzleHttp\Client();

		$res = $client->request(
			$this->method,
			$this->getApiUrl(),
			[
				"auth" => ['', $this->getApiPassword()],
				"body" => $batchContents,
				"timeout" => 60,
				"connect_timeout" => 60,
				"exceptions" => false
			]
        );

        $result = Array();

        $result['statusCode'] = $res->getStatusCode();

        $result['body'] = $res->getBody()->getContents();

        return $result;

    }

    /**
	 * Validate the batch request
	 *
	 * @return mixed
	 */
	public function validate() {

        $client = new \GuzzleHttp\Client();

        $res = $client->request(
            'POST',
            $this->getApiUrl() . '/validate',
            [
                "auth" => ['', $this->getApiPassword()],
                "body" => $this->batchSHA1,
                "timeout" => 60,
                "connect_timeout" => 60,
                "exceptions" => false
            ]
        );

        $result = Array();

        $result['statusCode'] = $res->getStatusCode();

        $result['body'] = $res->getBody()->getContents();

        return $result;
    }

    /**
	 * Get the batch response
	 *
	 * @return mixed
	 */
	public function response() {

        $client = new \GuzzleHttp\Client();

        $res = $client->request(
            'GET',
            $this->getApiUrl() . '/response',
            [
                "auth" => ['', $this->getApiPassword()],
                "body" => '',
                "timeout" => 60,
                "connect_timeout" => 60,
                "exceptions" => false
            ]
        );

        $result = Array();

        $result['statusCode'] = $res->getStatusCode();

        $result['body'] = $res->getBody()->getContents();

        return $result;
    }

    /**
	 * Get the batch status
	 *
	 * @return mixed
	 */
	public function status() {

        $client = new \GuzzleHttp\Client();

        $res = $client->request(
            'GET',
            $this->getApiUrl() . '/status',
            [
                "auth" => ['', $this->getApiPassword()],
                "body" => '',
                "timeout" => 60,
                "connect_timeout" => 60,
                "exceptions" => false
            ]
        );

        $result = Array();

        $result['statusCode'] = $res->getStatusCode();

        $result['body'] = $res->getBody()->getContents();

        return $result;
    }

	/**
	 * Gets error
	 *
	 * @return string
	 */
	public function getError() {

		return $this->error;
	}

	/**
	 * Gets user name for the api
	 *
	 * @return string
	 */
	public function getApiUsername() {

		return "merchant." . $this->getMerchant();
	}

	/**
	 * Gets password for the api
	 *
	 * @return string
	 */
	public function getApiPassword() {

		return $this->password;
	}

	/**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	private function getApiUrl() {


		$url = $this->url;

		if ( ! empty($this->version) ) {
			$url = $url . "version/" . $this->version . "/";
		}

		if ( ! empty($this->merchant) ) {
			$url = $url . "merchant/" . $this->merchant . "/";
		}

        if ( ! empty($this->batchName) ) {
			$url = $url . "batch/" . $this->batchName;
		}

		return $url;
	}
}
