<?php

namespace App\Services\Vocus\Classes;

use App\Services\Vocus\Classes\Param;

class Parameters
{

    /**
     * @var Param[] $Param
     * @access public
     */
    public $Param = null;

    /**
     * @param Param[] $Params
     * @access public
     */
    public function __construct($Params)
    {
        foreach ($Params as $key => $value) {

            $this->Param[] = new Param($value, $key);
        }
    }

}
