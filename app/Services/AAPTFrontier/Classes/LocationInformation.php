<?php

namespace App\Services\AAPTFrontier\Classes;

class LocationInformation
{

    /**
     * @var string $sourceSystemAddressId
     * @access public
     */
    public $sourceSystemAddressId = null;

    /**
     * @var string $serviceProvider
     * @access public
     */
    public $serviceProvider = null;

    /**
     * @var LocationId $locationId
     * @access public
     */
    public $locationId = null;

    /**
     * @var SiteAddress $address
     * @access public
     */
    public $address = null;

    /**
     * @var string $displayAddress
     * @access public
     */
    public $displayAddress = null;

    /**
     * @param string $sourceSystemAddressId
     * @param string $serviceProvider
     * @param LocationId $locationId
     * @param SiteAddress $address
     * @param string $displayAddress
     * @access public
     */
    public function __construct($sourceSystemAddressId, $serviceProvider, $locationId, $address, $displayAddress)
    {
      $this->sourceSystemAddressId = $sourceSystemAddressId;
      $this->serviceProvider = $serviceProvider;
      $this->locationId = $locationId;
      $this->address = $address;
      $this->displayAddress = $displayAddress;
    }

}
