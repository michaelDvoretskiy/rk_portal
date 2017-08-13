<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 12.08.2017
 * Time: 10:23
 */

namespace AppBundle\Utils;


class MyHelper
{
    public static function getPrefixed($prefix, array $array) {
        $res = [];
        foreach($array as $key => $val) {
            if (strpos($key, $prefix) === 0) {
                $res[substr($key, strlen($prefix) + 1)] = $val;
            }
        }
        return $res;
    }
}