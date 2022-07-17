<?php

namespace App\Helpers\AAPTFrontier\Classes;

class ServiceSpeedList
{

    /**
     * @var SpeedStatus[] $serviceSpeed
     * @access public
     */
    public $serviceSpeed = null;

    /**
     * @param SpeedStatus[] $serviceSpeed
     * @access public
     */
    public function __construct($serviceSpeed)
    {
      $this->serviceSpeed = $serviceSpeed;
    }

}
