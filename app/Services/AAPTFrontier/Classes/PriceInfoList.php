<?php

namespace App\Helpers\AAPTFrontier\Classes;

class PriceInfoList
{

    /**
     * @var PriceInfo[] $priceInformation
     * @access public
     */
    public $priceInformation = null;

    /**
     * @param PriceInfo[] $priceInformation
     * @access public
     */
    public function __construct($priceInformation)
    {
      $this->priceInformation = $priceInformation;
    }

}
