<?php

namespace App\Helpers;

class Site
{
    public static function name()
    {
        return request()->headers->get('site-name') ? request()->headers->get('site-name') : 'AlphaCall';
    }

    public static function domain()
    {
        return config('services.site.domain');
    }

    public static function siteCode()
    {
        return strtolower(config('services.site.code'));
    }
}
