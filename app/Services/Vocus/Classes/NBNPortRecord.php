<?php

namespace App\Services\Vocus\Classes;

class NBNPortRecord
{

    /**
     * @var String $ntdid
     * @access public
     */
    public $ntdid = null;

    /**
     * @var String $portNumber
     * @access public
     */
    public $portNumber = null;

    /**
     * @var String $portName
     * @access public
     */
    public $portName = null;

    /**
     * @var String $available
     * @access public
     */
    public $available = null;

    /**
     * @var String $portType
     * @access public
     */
    public $portType = null;

    /**
     * @param mixed $nbnPortRecord
     * @access public
     */
    public function __construct($nbnPortRecord)
    {
        if (!isset($nbnPortRecord)) {
            return null;
        }

        $xml = simplexml_load_string($nbnPortRecord);
        $nbnPortRecord = json_decode(json_encode($xml));

        $this->ntdid = $nbnPortRecord->NTDID ?? null;
        $this->portNumber = $nbnPortRecord->PortNumber ?? null;
        $this->portName = $nbnPortRecord->PortName ?? null;
        $this->available = $nbnPortRecord->Available ?? null;
        $this->portType = $nbnPortRecord->PortType ?? null;
    }
}
