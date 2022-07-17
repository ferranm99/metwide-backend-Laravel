<?php

namespace App\Helpers\AAPTFrontier\Classes;

class SpeedStatus
{

    /**
     * @var ServiceSpeed $serviceSpeed
     * @access public
     */
    public $serviceSpeed = null;

    /**
     * @var TestResult $status
     * @access public
     */
    public $status = null;

    /**
     * @param ServiceSpeed $serviceSpeed
     * @param TestResult $status
     * @access public
     */
    public function __construct($serviceSpeed, $status)
    {
      $this->serviceSpeed = $serviceSpeed;
      $this->status = $status;
    }

}
