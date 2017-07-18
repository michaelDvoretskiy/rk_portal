<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 18.07.2017
 * Time: 10:18
 */

namespace KvintBundle\Entity;


class KvintTypeConverter
{
    public static function TFasBOOL($T) {
        if ($T == "T") {
            return true;
        }
        return false;
    }
    public static function BOOLasTF($boolVal) {
        if ($boolVal) {
            return "T";
        }
        return "F";
    }
}