<?php

namespace App\Helpers\AAPTFrontier\Classes;

class ServiceProviderLocation
{

    /**
     * @var LocationIdProvider $serviceProvider
     * @access public
     */
    public $serviceProvider = null;

    /**
     * @var LocationList $locationList
     * @access public
     */
    public $locationList = null;

    /**
     * @param LocationIdProvider $serviceProvider
     * @param LocationList $locationList
     * @access public
     */
    public function __construct($serviceProvider, $locationList)
    {
      $this->serviceProvider = $serviceProvider;
      $this->locationList = $locationList;
    }

}
