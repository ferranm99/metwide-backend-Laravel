<?php

namespace App\Services\AAPTFrontier\Classes;

class PriceInfo
{

    /**
     * @var string $description
     * @access public
     */
    public $description = null;

    /**
     * @var Currency $oneOffCharge
     * @access public
     */
    public $oneOffCharge = null;

    /**
     * @var Currency $monthlyCharge
     * @access public
     */
    public $monthlyCharge = null;

    /**
     * @var ContractTermMonths $contractTerm
     * @access public
     */
    public $contractTerm = null;

    /**
     * @param string $description
     * @param Currency $oneOffCharge
     * @param Currency $monthlyCharge
     * @param ContractTermMonths $contractTerm
     * @access public
     */
    public function __construct($description, $oneOffCharge, $monthlyCharge, $contractTerm)
    {
      $this->description = $description;
      $this->oneOffCharge = $oneOffCharge;
      $this->monthlyCharge = $monthlyCharge;
      $this->contractTerm = $contractTerm;
    }

}
