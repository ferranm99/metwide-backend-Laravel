<?php

namespace App\Helpers\AAPTFrontier\Classes;

class SiteAddress
{

    /**
     * @var AddressInformation $addressInformation
     * @access public
     */
    public $addressInformation = null;

    /**
     * @var SubAddressType $subAddressType
     * @access public
     */
    public $subAddressType = null;

    /**
     * @var SubAddressNumber $subAddressNumber
     * @access public
     */
    public $subAddressNumber = null;

    /**
     * @var StreetNumber $streetNumber
     * @access public
     */
    public $streetNumber = null;

    /**
     * @var StreetNumberSuffix $streetNumberSuffix
     * @access public
     */
    public $streetNumberSuffix = null;

    /**
     * @var StreetName $streetName
     * @access public
     */
    public $streetName = null;

    /**
     * @var StreetType $streetType
     * @access public
     */
    public $streetType = null;

    /**
     * @var StreetSuffix $streetSuffix
     * @access public
     */
    public $streetSuffix = null;

    /**
     * @var Suburb $suburb
     * @access public
     */
    public $suburb = null;

    /**
     * @var State $state
     * @access public
     */
    public $state = null;

    /**
     * @var Postcode $postcode
     * @access public
     */
    public $postcode = null;

    /**
     * @param AddressInformation $addressInformation
     * @param SubAddressType $subAddressType
     * @param SubAddressNumber $subAddressNumber
     * @param StreetNumber $streetNumber
     * @param StreetNumberSuffix $streetNumberSuffix
     * @param StreetName $streetName
     * @param StreetType $streetType
     * @param StreetSuffix $streetSuffix
     * @param Suburb $suburb
     * @param State $state
     * @param Postcode $postcode
     * @access public
     */
    public function __construct($addressInformation, $subAddressType, $subAddressNumber, $streetNumber, $streetNumberSuffix, $streetName, $streetType, $streetSuffix, $suburb, $state, $postcode)
    {
      $this->addressInformation = $addressInformation;
      $this->subAddressType = $subAddressType;
      $this->subAddressNumber = $subAddressNumber;
      $this->streetNumber = $streetNumber;
      $this->streetNumberSuffix = $streetNumberSuffix;
      $this->streetName = $streetName;
      $this->streetType = $streetType;
      $this->streetSuffix = $streetSuffix;
      $this->suburb = $suburb;
      $this->state = $state;
      $this->postcode = $postcode;
    }

}
