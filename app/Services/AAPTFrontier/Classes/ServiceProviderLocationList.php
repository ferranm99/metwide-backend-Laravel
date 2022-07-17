<?php

namespace App\Helpers\AAPTFrontier\Classes;

class ServiceProviderLocationList
{

    /**
     * @var ServiceProviderLocation[] $serviceProviderLocationList
     * @access public
     */
    public $serviceProviderLocationList = null;

    /**
     * @param ServiceProviderLocation[] $serviceProviderLocationList
     * @access public
     */
    public function __construct($serviceProviderLocationList)
    {
      $this->serviceProviderLocationList = $serviceProviderLocationList;
    }

}
