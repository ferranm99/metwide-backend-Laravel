<?php

namespace App\Helpers;

class GeneratePassword
{

    /**
     * Generate password
     *
     * @param int $length
     *
     * @return String
     */
	public static function value($length = 10) {

        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
        return substr($random, 0, $length);
	}

}
