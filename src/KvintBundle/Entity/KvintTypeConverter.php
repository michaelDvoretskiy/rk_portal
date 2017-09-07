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
    public static function NullToVal($variable, $nullVal) {
        if (is_null($variable)) {
            return $nullVal;
        }
        return $variable;
    }
    public static function ValToNull($variable, $nullVal) {
        if ($variable == $nullVal) {
            return null;
        }
        return $variable;
    }
    public static function DateToString($variable) {
        if (!is_null($variable)) {
            return $variable->format("Y-m-d");
        }
        return null;
    }
}