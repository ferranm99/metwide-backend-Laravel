<?php

namespace App\Services\Opticomm\Classes;

class PortUtilisation
{

    /**
     * @var string $portNo
     * @access public
     */
    public $portNo = null;

    /**
     * @var string $productType
     * @access public
     */
    public $productType = null;

    /**
     * @access public
     */
    public function __construct($port)
    {
        $this->portNo = $port->Port_No;
        $this->productType = $port->Product_Type;
    }

}
