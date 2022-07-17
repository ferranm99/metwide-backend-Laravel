<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyProductRequest
{

    /**
     * @var QualifyNationalWholesaleBroadbandProductRequest $qualifyNationalWholesaleBroadbandProductRequest
     * @access public
     */
    public $qualifyNationalWholesaleBroadbandProductRequest = null;

    /**
     * @var QualifyRequestXpressProductRequest $qualifyRequestXpressProductRequest
     * @access public
     */
    public $qualifyRequestXpressProductRequest = null;

    /**
     * @var QualifyELanProductRequest $qualifyELanProductRequest
     * @access public
     */
    public $qualifyELanProductRequest = null;

    /**
     * @var QualifyELineProductRequest $qualifyELineProductRequest
     * @access public
     */
    public $qualifyELineProductRequest = null;

    /**
     * @var QualifyHomeBroadbandBundleProductRequest $qualifyHomeBroadbandBundleProductRequest
     * @access public
     */
    public $qualifyHomeBroadbandBundleProductRequest = null;

    /**
     * @var QualifyConsumerBroadbandProductRequest $qualifyConsumerBroadbandProductRequest
     * @access public
     */
    public $qualifyConsumerBroadbandProductRequest = null;

    /**
     * @var QualifyFastFibreProductRequest $qualifyFastFibreProductRequest
     * @access public
     */
    public $qualifyFastFibreProductRequest = null;

    /**
     * @param QualifyNationalWholesaleBroadbandProductRequest $qualifyNationalWholesaleBroadbandProductRequest
     * @param QualifyRequestXpressProductRequest $qualifyRequestXpressProductRequest
     * @param QualifyELanProductRequest $qualifyELanProductRequest
     * @param QualifyELineProductRequest $qualifyELineProductRequest
     * @param QualifyHomeBroadbandBundleProductRequest $qualifyHomeBroadbandBundleProductRequest
     * @param QualifyConsumerBroadbandProductRequest $qualifyConsumerBroadbandProductRequest
     * @param QualifyFastFibreProductRequest $qualifyFastFibreProductRequest
     * @access public
     */
    public function __construct($qualifyNationalWholesaleBroadbandProductRequest, $qualifyRequestXpressProductRequest, $qualifyELanProductRequest, $qualifyELineProductRequest, $qualifyHomeBroadbandBundleProductRequest, $qualifyConsumerBroadbandProductRequest, $qualifyFastFibreProductRequest)
    {
      $this->qualifyNationalWholesaleBroadbandProductRequest = $qualifyNationalWholesaleBroadbandProductRequest;
      $this->qualifyRequestXpressProductRequest = $qualifyRequestXpressProductRequest;
      $this->qualifyELanProductRequest = $qualifyELanProductRequest;
      $this->qualifyELineProductRequest = $qualifyELineProductRequest;
      $this->qualifyHomeBroadbandBundleProductRequest = $qualifyHomeBroadbandBundleProductRequest;
      $this->qualifyConsumerBroadbandProductRequest = $qualifyConsumerBroadbandProductRequest;
      $this->qualifyFastFibreProductRequest = $qualifyFastFibreProductRequest;
    }

}
