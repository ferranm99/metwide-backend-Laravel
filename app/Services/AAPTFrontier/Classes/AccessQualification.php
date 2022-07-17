<?php

namespace App\Services\AAPTFrontier\Classes;

class AccessQualification
{

    /**
     * @var QualificationID $id
     * @access public
     */
    public $id = null;

    /**
     * @var TestResult $qualificationResult
     * @access public
     */
    public $qualificationResult = null;

    /**
     * @var AccessMethod $accessMethod
     * @access public
     */
    public $accessMethod = null;

    /**
     * @var AccessType $accessType
     * @access public
     */
    public $accessType = null;

    /**
     * @var PriceZone $priceZone
     * @access public
     */
    public $priceZone = null;

    /**
     * @var Speed $maximumDownBandwidth
     * @access public
     */
    public $maximumDownBandwidth = null;

    /**
     * @var Speed $maximumUpBandwidth
     * @access public
     */
    public $maximumUpBandwidth = null;

    /**
     * @var ServiceSpeedList $availableServiceSpeeds
     * @access public
     */
    public $availableServiceSpeeds = null;

    /**
     * @var QualificationTestOutcome[] $testOutcomes
     * @access public
     */
    public $testOutcomes = null;

    /**
     * @var NBNCopperPairList $nbnCopperPairList
     * @access public
     */
    public $nbnCopperPairList = null;

    /**
     * @var NBNNewDevelopmentsChargeApplies $nbnNewDevelopmentsChargeApplies
     * @access public
     */
    public $nbnNewDevelopmentsChargeApplies = null;

    /**
     * @var NBNNetworkTerminationDeviceList $nbnNetworkTerminationDeviceList
     * @access public
     */
    public $nbnNetworkTerminationDeviceList = null;

    /**
     * @param QualificationID $id
     * @param TestResult $qualificationResult
     * @param AccessMethod $accessMethod
     * @param AccessType $accessType
     * @param PriceZone $priceZone
     * @param Speed $maximumDownBandwidth
     * @param Speed $maximumUpBandwidth
     * @param ServiceSpeedList $availableServiceSpeeds
     * @param QualificationTestOutcome[] $testOutcomes
     * @param NBNCopperPairList $nbnCopperPairList
     * @param NBNNewDevelopmentsChargeApplies $nbnNewDevelopmentsChargeApplies
     * @param NBNNetworkTerminationDeviceList $nbnNetworkTerminationDeviceList
     * @access public
     */
    public function __construct($id, $qualificationResult, $accessMethod, $accessType, $priceZone, $maximumDownBandwidth, $maximumUpBandwidth, $availableServiceSpeeds, $testOutcomes, $nbnCopperPairList, $nbnNewDevelopmentsChargeApplies, $nbnNetworkTerminationDeviceList)
    {
      $this->id = $id;
      $this->qualificationResult = $qualificationResult;
      $this->accessMethod = $accessMethod;
      $this->accessType = $accessType;
      $this->priceZone = $priceZone;
      $this->maximumDownBandwidth = $maximumDownBandwidth;
      $this->maximumUpBandwidth = $maximumUpBandwidth;
      $this->availableServiceSpeeds = $availableServiceSpeeds;
      $this->testOutcomes = $testOutcomes;
      $this->nbnCopperPairList = $nbnCopperPairList;
      $this->nbnNewDevelopmentsChargeApplies = $nbnNewDevelopmentsChargeApplies;
      $this->nbnNetworkTerminationDeviceList = $nbnNetworkTerminationDeviceList;
    }

}
