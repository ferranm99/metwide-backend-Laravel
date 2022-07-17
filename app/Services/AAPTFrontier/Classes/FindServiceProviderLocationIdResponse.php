<?php

namespace App\Services\AAPTFrontier\Classes;

use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;

class FindServiceProviderLocationIdResponse
{

    /**
     * @var ServiceProviderLocationList $serviceProviderLocationList
     * @access public
     */
    public $serviceProviderLocationList = null;

    /**
     * @param ServiceProviderLocationList $serviceProviderLocationList
     * @access public
     */
    public function __construct($serviceProviderLocationList)
    {

      $this->serviceProviderLocationList = $serviceProviderLocationList;
    }

}
