<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualifyFastFibreProductRequest
{

    /**
     * @var ComplexAddress $address
     * @access public
     */
    public $address = null;

    /**
     * @var LocationId $nbnLocationID
     * @access public
     */
    public $nbnLocationID = null;

    /**
     * @param ComplexAddress $address
     * @param LocationId $nbnLocationID
     * @access public
     */
    public function __construct($address, $nbnLocationID)
    {
      $this->address = $address;
      $this->nbnLocationID = $nbnLocationID;
    }

}
