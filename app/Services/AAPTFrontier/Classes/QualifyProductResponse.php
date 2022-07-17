<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyProductResponse
{

    /**
     * @var QualificationID $qualificationID
     * @access public
     */
    public $qualificationID = null;

    /**
     * @var QualificationSiteDetails $siteDetails
     * @access public
     */
    public $siteDetails = null;

    /**
     * @var FNN $endCSN
     * @access public
     */
    public $endCSN = null;

    /**
     * @var SiteAddress $siteAddress
     * @access public
     */
    public $siteAddress = null;

    /**
     * @var CableDetails $telstraCableDetails
     * @access public
     */
    public $telstraCableDetails = null;

    /**
     * @var AccessQualification[] $accessQualificationList
     * @access public
     */
    public $accessQualificationList = null;

    /**
     * @param QualificationID $qualificationID
     * @param QualificationSiteDetails $siteDetails
     * @param FNN $endCSN
     * @param SiteAddress $siteAddress
     * @param CableDetails $telstraCableDetails
     * @param AccessQualification[] $accessQualificationList
     * @access public
     */
    public function __construct($qualificationID, $siteDetails, $endCSN, $siteAddress, $telstraCableDetails, $accessQualificationList)
    {
      $this->qualificationID = $qualificationID;
      $this->siteDetails = $siteDetails;
      $this->endCSN = $endCSN;
      $this->siteAddress = $siteAddress;
      $this->telstraCableDetails = $telstraCableDetails;
      $this->accessQualificationList = $accessQualificationList;
    }

}
