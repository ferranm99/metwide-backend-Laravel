<?php

namespace App\Services\AAPTFrontier\Classes;

class FindServiceProviderLocationIdRequest
{

    /**
     * @var ComplexAddress $address
     * @access public
     */
    public $address = null;

    /**
     * @var FixedTelephoneNumber $serviceNumber
     * @access public
     */
    public $serviceNumber = null;

    /**
     * @var LocationIdProvider[] $serviceProvider
     * @access public
     */
    public $serviceProvider = null;

    /**
     * @param ComplexAddress $address
     * @param FixedTelephoneNumber $serviceNumber
     * @param LocationIdProvider[] $serviceProvider
     * @access public
     */
    public function __construct($address, $serviceNumber, $serviceProvider)
    {
      $this->address = $address;
      $this->serviceNumber = $serviceNumber;
      $this->serviceProvider = $serviceProvider;
    }

}
