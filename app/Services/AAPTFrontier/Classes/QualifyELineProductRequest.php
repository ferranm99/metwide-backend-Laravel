<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyELineProductRequest
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
     * @var ELineType $eLineType
     * @access public
     */
    public $eLineType = null;

    /**
     * @var EthernetAccessType $ethernetAccessType
     * @access public
     */
    public $ethernetAccessType = null;

    /**
     * @param FixedTelephoneNumber $endCSN
     * @param LocationId $aaptLocationID
     * @param LocationId $telstraLocationID
     * @param ELineType $eLineType
     * @param EthernetAccessType $ethernetAccessType
     * @access public
     */
    public function __construct($endCSN, $aaptLocationID, $telstraLocationID, $eLineType, $ethernetAccessType)
    {
      $this->endCSN = $endCSN;
      $this->aaptLocationID = $aaptLocationID;
      $this->telstraLocationID = $telstraLocationID;
      $this->eLineType = $eLineType;
      $this->ethernetAccessType = $ethernetAccessType;
    }

}
