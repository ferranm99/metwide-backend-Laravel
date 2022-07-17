<?php

namespace App\Services\AAPTFrontier\Classes;

class GetFastFibreProductPricingDetailRequest
{

    /**
     * @var QualificationID $qualificationID
     * @access public
     */
    public $qualificationID = null;

    /**
     * @var AccessMethod $accessMethod
     * @access public
     */
    public $accessMethod = null;

    /**
     * @var ServiceSpeed $serviceSpeed
     * @access public
     */
    public $serviceSpeed = null;

    /**
     * @param QualificationID $qualificationID
     * @param AccessMethod $accessMethod
     * @param ServiceSpeed $serviceSpeed
     * @access public
     */
    public function __construct($qualificationID, $accessMethod, $serviceSpeed)
    {
      $this->qualificationID = $qualificationID;
      $this->accessMethod = $accessMethod;
      $this->serviceSpeed = $serviceSpeed;
    }

}
