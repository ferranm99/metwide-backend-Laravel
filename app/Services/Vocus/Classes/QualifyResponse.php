<?php

namespace App\Services\Vocus\Classes;

use App\Services\Vocus\Classes\CopperPairRecord;
use App\Services\Vocus\Classes\NBNPortRecord;

class QualifyResponse
{

    /**
     * @var String $serviceabilityMessage
     * @access public
     */
    public $serviceabilityMessage = null;

    /**
     * @var String $transactionID
     * @access public
     */
    public $transactionID = null;

    /**
     * @var String $responseType
     * @access public
     */
    public $responseType = null;

    /**
     * @var String $result
     * @access public
     */
    public $result = null;

    /**
     * @var String $serviceType
     * @access public
     */
    public $serviceType = null;

    /**
     * @var String $serviceClass
     * @access public
     */
    public $serviceClass = null;

    /**
     * @var String $dataPort
     * @access public
     */
    public $dataPort = null;

    /**
     * @var String $voicePort
     * @access public
     */
    public $voicePort = null;

    /**
     * @var NBNPortRecord[] $nbnPortRecord
     * @access public
     */
    public $nbnPortRecord = null;

    /**
     * @var String $csa
     * @access public
     */
    public $csa = null;

    /**
     * @var String $cvcid
     * @access public
     */
    public $cvcid = null;

    /**
     * @var String $zone
     * @access public
     */
    public $zone = null;

    /**
     * @var String $voiceCVCID
     * @access public
     */
    public $voiceCVCID = null;

    /**
     * @var String $trafficClass1
     * @access public
     */
    public $trafficClass1 = null;

    /**
     * @var String $trafficClass2
     * @access public
     */
    public $trafficClass2 = null;

    /**
     * @var String $trafficClass3
     * @access public
     */
    public $trafficClass3 = null;

    /**
     * @var String $trafficClass4
     * @access public
     */
    public $trafficClass4 = null;

    /**
     * @var String $availableCTAG
     * @access public
     */
    public $availableCTAG = null;

    /**
     * @var String $stag
     * @access public
     */
    public $stag = null;

    /**
     * @var String $ntdid
     * @access public
     */
    public $ntdid = null;

    /**
     * @var String $battery
     * @access public
     */
    public $battery = null;

    /**
     * @var String $connectionType
     * @access public
     */
    public $connectionType = null;

    /**
     * @var String $developmentCharge
     * @access public
     */
    public $developmentCharge = null;

    /**
     * @var CopperPairRecord[] $copperPairRecord
     * @access public
     */
    public $copperPairRecord = null;

    /**
     * @var String $activationDate
     * @access public
     */
    public $activationDate = null;

    /**
     * @var String $copperDisconnectionDate
     * @access public
     */
    public $copperDisconnectionDate = null;



    /**
     * @param mixed $qualifyResponse
     * @access public
     */
    public function __construct($qualifyResponse)
    {

        $this->transactionID = $qualifyResponse->TransactionID;
        $this->responseType = $qualifyResponse->ResponseType;

        foreach ($qualifyResponse->Parameters->Param as $param) {
            switch ($param->id) {
                case 'Result':
                    $this->result = $param->_;
                    break;
                case 'ServiceType':
                    $this->serviceType = $param->_;
                    break;
                case 'ServiceClass':
                    $this->serviceClass = $param->_;
                    break;
                case 'DataPort':
                    $this->dataPort = $param->_;
                    break;
                case 'VoicePort':
                    $this->voicePort = $param->_;
                    break;
                case 'NBNPortRecord':
                    $portRecord = new NBNPortRecord($param->_);
                    if (isset($portRecord)) {
                        $this->nbnPortRecord[] = $portRecord;
                    }
                    break;
                case 'CSA':
                    $this->csa = $param->_;
                    break;
                case 'CVCID':
                    $this->cvcid = $param->_;
                    break;
                case 'Zone':
                    $this->zone = $param->_;
                    break;
                case 'VoiceCVCID':
                    $this->voiceCVCID = $param->_;
                    break;
                case 'TrafficClass1':
                    $this->trafficClass1 = $param->_;
                    break;
                case 'TrafficClass2':
                    $this->trafficClass2 = $param->_;
                    break;
                case 'TrafficClass3':
                    $this->trafficClass3 = $param->_;
                    break;
                case 'TrafficClass4':
                    $this->trafficClass4 = $param->_;
                    break;
                case 'AvailableCTAG':
                    $this->availableCTAG = $param->_;
                    break;
                case 'Stag':
                    $this->stag = $param->_;
                    break;
                case 'NTDID':
                    $this->ntdid = $param->_;
                    break;
                case 'Battery':
                    $this->battery = $param->_;
                    break;
                case 'ConnectionType':
                    $this->connectionType = $param->_;
                    break;
                case 'DevelopmentCharge':
                    $this->developmentCharge = $param->_;
                    break;
                case 'CopperPairRecord':
                    $portRecord = new CopperPairRecord($param->_);
                    if (isset($portRecord)) {
                        $this->copperPairRecord[] = $portRecord;
                    }
                    break;
                case 'ActivationDate':
                    $this->activationDate = $param->_;
                    break;
                case 'CopperDisconnectionDate':
                    $this->copperDisconnectionDate = $param->_;
                    break;
                default:
                    break;
            }
        }
    }
}
