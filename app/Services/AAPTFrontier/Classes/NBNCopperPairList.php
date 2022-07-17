<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNCopperPairList
{

    /**
     * @var NBNCopperPair[] $nbnCopperPairList
     * @access public
     */
    public $nbnCopperPairList = null;

    /**
     * @param NBNCopperPair[] $nbnCopperPairList
     * @access public
     */
    public function __construct($nbnCopperPairList)
    {
      $this->nbnCopperPairList = $nbnCopperPairList;
    }

}
