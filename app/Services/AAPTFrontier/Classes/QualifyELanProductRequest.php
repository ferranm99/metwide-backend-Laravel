<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyELanProductRequest
{

    /**
     * @var FixedTelephoneNumber $endCSN
     * @access public
     */
    public $endCSN = null;

    /**
     * @var LocationId $aaptLocationID
     * @access public
     */
    public $aaptLocationID = null;

    /**
     * @var LocationId $telstraLocationID
     * @access public
     */
    public $telstraLocationID = null;

    /**
     * @var EthernetQosType $ethernetQosType
     * @access public
     */
    public $ethernetQosType = null;

    /**
     * @var EthernetAccessType $ethernetAccessType
     * @access public
     */
    public $ethernetAccessType = null;

    /**
     * @param FixedTelephoneNumber $endCSN
     * @param LocationId $aaptLocationID
     * @param LocationId $telstraLocationID
     * @param EthernetQosType $ethernetQosType
     * @param EthernetAccessType $ethernetAccessType
     * @access public
     */
    public function __construct($endCSN, $aaptLocationID, $telstraLocationID, $ethernetQosType, $ethernetAccessType)
    {
      $this->endCSN = $endCSN;
      $this->aaptLocationID = $aaptLocationID;
      $this->telstraLocationID = $telstraLocationID;
      $this->ethernetQosType = $ethernetQosType;
      $this->ethernetAccessType = $ethernetAccessType;
    }

}
