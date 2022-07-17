<?php

namespace App\Services\Vocus\Classes;

class UniqueID
{

    /**
     * Generate serviceID
     *
     * @param int $upperLimit
     *
     * @return String
     */
	public static function value(int $upperLimit = 99) {

        $uid = time() . '' . rand(0, $upperLimit);
        return str_pad($uid, 14, '0', STR_PAD_LEFT);
	}

}
