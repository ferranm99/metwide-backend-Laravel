<?php

namespace App\Helpers\AAPTFrontier\Classes;

class Speed
{

    /**
     * @var SpeedValue $value
     * @access public
     */
    public $value = null;

    /**
     * @var SpeedQuantifier $quantifier
     * @access public
     */
    public $quantifier = null;

    /**
     * @param SpeedValue $value
     * @param SpeedQuantifier $quantifier
     * @access public
     */
    public function __construct($value, $quantifier)
    {
      $this->value = $value;
      $this->quantifier = $quantifier;
    }

}
