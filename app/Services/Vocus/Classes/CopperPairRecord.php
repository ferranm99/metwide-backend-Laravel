<?php

namespace App\Services\Vocus\Classes;

class CopperPairRecord
{

    /**
     * @var String $copperPairID
     * @access public
     */
    public $copperPairID = null;

    /**
     * @var String $copperPairStatus
     * @access public
     */
    public $copperPairStatus = null;

    /**
     * @var String $nbnServiceStatus
     * @access public
     */
    public $nbnServiceStatus = null;

    /**
     * @var String $serviceClass
     * @access public
     */
    public $serviceClass = null;

    /**
     * @var String $potsInterconnect
     * @access public
     */
    public $potsInterconnect = null;

    /**
     * @var String $potsMatch
     * @access public
     */
    public $potsMatch = null;

    /**
     * @var String $uploadSpeed
     * @access public
     */
    public $uploadSpeed = null;

    /**
     * @var String $downloadSpeed
     * @access public
     */
    public $downloadSpeed = null;

    /**
     * @var String $networkCoExist
     * @access public
     */
    public $networkCoExist = null;

    /**
     * @var String $extraCharge
     * @access public
     */
    public $extraCharge = null;


    /**
     * @param mixed $copperPairRecord
     * @access public
     */
    public function __construct($copperPairRecord)
    {
        if (!isset($copperPairRecord)) {
            return null;
        }

        $xml = simplexml_load_string($copperPairRecord);
        $copperPairRecord = json_decode(json_encode($xml));


        $this->copperPairID = $copperPairRecord->CopperPairID;
        $this->copperPairStatus = $copperPairRecord->CopperPairStatus;
        $this->nbnServiceStatus = $copperPairRecord->NBNServiceStatus ?? null;
        $this->serviceClass = $copperPairRecord->ServiceClass ?? null;
        $this->potsInterconnect = $copperPairRecord->POTSInterconnect ?? null;
        $this->potsMatch = $copperPairRecord->POTSMatch ?? null;
        $this->uploadSpeed = $copperPairRecord->UploadSpeed ?? null;
        $this->downloadSpeed = $copperPairRecord->DownloadSpeed ?? null;
        $this->networkCoExist = $copperPairRecord->NetworkCoExist ?? null;
        $this->extraCharge = $copperPairRecord->ExtraCharge ?? null;
    }
}
