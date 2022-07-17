<?php

namespace App\Services\AAPTFrontier\Classes;

class ComplexAddress
{

    /**
     * @var string $ruralMailNumber
     * @access public
     */
    public $ruralMailNumber = null;

    /**
     * @var string $ruralMailType
     * @access public
     */
    public $ruralMailType = null;

    /**
     * @var string $levelNumber
     * @access public
     */
    public $levelNumber = null;

    /**
     * @var string $levelType
     * @access public
     */
    public $levelType = null;

    /**
     * @var string $unitNumber
     * @access public
     */
    public $unitNumber = null;

    /**
     * @var string $unitType
     * @access public
     */
    public $unitType = null;

    /**
     * @var string $planNumber
     * @access public
     */
    public $planNumber = null;

    /**
     * @var string $lotNumber
     * @access public
     */
    public $lotNumber = null;

    /**
     * @var string $streetNumber
     * @access public
     */
    public $streetNumber = null;

    /**
     * @var string $streetNumberSuffix
     * @access public
     */
    public $streetNumberSuffix = null;

    /**
     * @var string $siteName
     * @access public
     */
    public $siteName = null;

    /**
     * @var string $streetName
     * @access public
     */
    public $streetName = null;

    /**
     * @var string $streetType
     * @access public
     */
    public $streetType = null;

    /**
     * @var string $streetTypeSuffix
     * @access public
     */
    public $streetTypeSuffix = null;

    /**
     * @var string $suburb
     * @access public
     */
    public $suburb = null;

    /**
     * @var string $state
     * @access public
     */
    public $state = null;

    /**
     * @var string $postcode
     * @access public
     */
    public $postcode = null;

    /**
     * @param mixed $address
     *
     * @access public
     */
    public function __construct($address)
    {
        $this->levelNumber = $address['level_number'] ?? null;
        $this->levelType = $address['level_type'] ?? null;
        $this->unitNumber = $address['unit_identifier'] ?? null;
        $this->unitType = $address['unit_type'] ?? null;
        $this->lotNumber = $address['lot_identifier'] ?? null;
        $this->streetNumber  = $address['street_number_1'] ?? null;
        $this->streetNumberSuffix = $address['street_number_2'] ?? null;
        $this->streetName = $address['street_name'] ?? null;
        $this->streetType = $address['street_type'] ?? null;
        $this->streetTypeSuffix = $address['street_suffix'] ?? null;
        $this->suburb  = $address['locality_name'] ?? null;
        $this->state = $address['state_territory'] ?? null;
        $this->postcode  = $address['postcode'] ?? null;
    }
}
