<?php

namespace App\Services\AAPTFrontier\Classes;

class GetFastFibreProductPricingDetailResponse
{

    /**
     * @var PriceInfoList $priceList
     * @access public
     */
    public $priceList = null;

    /**
     * @param PriceInfoList $priceList
     * @access public
     */
    public function __construct($priceList)
    {
      $this->priceList = $priceList;
    }

}
