<?php

namespace App\Services\AAPTFrontier\Classes;

class LocationList
{

    /**
     * @var LocationInformation[] $addressInformation
     * @access public
     */
    public $addressInformation = null;

    /**
     * @param LocationInformation[] $addressInformation
     * @access public
     */
    public function __construct($addressInformation)
    {
      $this->addressInformation = $addressInformation;
    }

}
