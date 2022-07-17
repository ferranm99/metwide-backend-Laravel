<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyNationalWholesaleBroadbandProductRequest
{

    /**
     * @var FNN $endCSN
     * @access public
     */
    public $endCSN = null;

    /**
     * @var LocationId $telstraLocationID
     * @access public
     */
    public $telstraLocationID = null;

    /**
     * @var LocationId $nbnLocationID
     * @access public
     */
    public $nbnLocationID = null;

    /**
     * @var boolean $returnExtendedNbnSqData
     * @access public
     */
    public $returnExtendedNbnSqData = null;

    /**
     * @var boolean $standAloneQualification
     * @access public
     */
    public $standAloneQualification = null;

    /**
     * @var boolean $allowConditionalAccessMethods
     * @access public
     */
    public $allowConditionalAccessMethods = null;

    /**
     * @var date $customerAuthorisationDate
     * @access public
     */
    public $customerAuthorisationDate = null;

    /**
     * @var LocationIdProvider $qualifyOnlyOnCarrier
     * @access public
     */
    public $qualifyOnlyOnCarrier = null;

    /**
     * @param FNN $endCSN
     * @param LocationId $telstraLocationID
     * @param LocationId $nbnLocationID
     * @param boolean $returnExtendedNbnSqData
     * @param boolean $standAloneQualification
     * @param boolean $allowConditionalAccessMethods
     * @param date $customerAuthorisationDate
     * @param LocationIdProvider $qualifyOnlyOnCarrier
     * @access public
     */
    public function __construct($endCSN, $telstraLocationID, $nbnLocationID, $returnExtendedNbnSqData, $standAloneQualification, $allowConditionalAccessMethods, $customerAuthorisationDate, $qualifyOnlyOnCarrier)
    {
      $this->endCSN = $endCSN;
      $this->telstraLocationID = $telstraLocationID;
      $this->nbnLocationID = $nbnLocationID;
      $this->returnExtendedNbnSqData = $returnExtendedNbnSqData;
      $this->standAloneQualification = $standAloneQualification;
      $this->allowConditionalAccessMethods = $allowConditionalAccessMethods;
      $this->customerAuthorisationDate = $customerAuthorisationDate;
      $this->qualifyOnlyOnCarrier = $qualifyOnlyOnCarrier;
    }

}
