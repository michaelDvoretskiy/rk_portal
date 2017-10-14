<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 14.10.2017
 * Time: 9:59
 */

namespace AppBundle\Utils;


class AmountInWords
{
    private static $_1_2 = [
        1 => "один", 2 => "два"
    ];

    private static $_1_19 = [
        1 => "одна",
        2 => "дві",
        3 => "три",
        4 => "чотири",
        5 => "п'ять",
        6 => "шість",
        7 => "сім",
        8 => "вісім",
        9 => "дев'ять",
        10 => "десять",
        11 => "одинадцять",
        12 => "дванадцять",
        13 => "тринадцять",
        14 => "чотирнадцять",
        15 => "п'ятнадцять",
        16 => "шістнадцять",
        17 => "сімнадцять",
        18 => "вісімнадцять",
        19 => "дев'ятнадцять",
    ];

    private static $des = [
        2 => "двадцять",
        3 => "тридцять",
        4 => "сорок",
        5 => "п'ятдесят",
        6 => "шістдесят",
        7 => "сімдесят",
        8 => "вісімдесят",
        9 => "дев'яносто",
    ];

    private static $hang = [
        1 => "сто",
        2 => "двісті",
        3 => "триста",
        4 => "чотириста",
        5 => "п'ятсот",
        6 => "шістсот",
        7 => "сімсот",
        8 => "вісімсот",
        9 => "дев'ятьсот",
    ];

    private static $namecurr = [
        1 => "гривня", // 1
        2 => "гривні", // 2, 3, 4
        3 => "гривень", // >4
    ];

    private static $nametho = [
        1 => "тисяча", // 1
        2 => "тисячі", // 2, 3, 4
        3 => "тисяч", // >4
    ];

    private static $namemil = [
        1 => "мільйон", // 1
        2 => "мільйона", // 2, 3, 4
        3 => "мільйонів", // >4
    ];

    private static $namemrd = [
        1 => "мільярд", // 1
        2 => "мільярда", // 2, 3, 4
        3 => "мільярдів", // >4
    ];

    public static function num2text_ua($num) {

        $num = trim(preg_replace('~s+~s', '', $num)); // отсекаем пробелы
        if (preg_match("/, /", $num)) {
            $num = preg_replace("/, /", ".", $num);
        } // преобразует запятую
        if (is_numeric($num)) {
            $num = round($num, 2); // Округляем до сотых (копеек)
            $num_arr = explode(".", $num);
            $amount = $num_arr[0]; // переназначаем для удобства, $amount - сумма без копеек
            if (strlen($amount) <= 3) {
                $res = implode(" ", Triada($amount)) . self::Currency($amount);
            } else {
                $amount1 = $amount;
                while (strlen($amount1) >= 3) {
                    $temp_arr[] = substr($amount1, -3); // засовываем в массив по 3
                    $amount1 = substr($amount1, 0, -3); // уменьшаем массив на 3 с конца
                }
                if ($amount1 != '') {
                    $temp_arr[] = $amount1;
                } // добавляем то, что не добавилось по 3
                $i = 0;
                foreach ($temp_arr as $temp_var) { // переводим числа в буквы по 3 в массиве
                    $i++;
                    if ($i == 3 || $i == 4) { // миллионы и миллиарды мужского рода, а больше миллирда вам все равно не заплатят
                        if ($temp_var == '000') {

                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", Triada($temp_var, 1)) . self::GetNum($i, $temp_var);
                        } # if
                    } else {
                        if ($temp_var == '000') {
                            $temp_res[] = '';
                        } else {
                            $temp_res[] = implode(" ", self::Triada($temp_var)) . self::GetNum($i, $temp_var);
                        } # if
                    } # else
                } # foreach
                $temp_res = array_reverse($temp_res); // разворачиваем массив
                $res = implode(" ", $temp_res) . self::Currency($amount);
            }
            if (!isset($num_arr[1]) || $num_arr[1] == '') {
                $num_arr[1] = '00';
            }
            return $res . ', ' . $num_arr[1] . ' коп.';
        } # if
    }

    private static function Triada($amount, $case = null) {
        $count = strlen($amount);
        for ($i = 0; $i < $count; $i++) {
            $triada[] = substr($amount, $i, 1);
        }
        $triada = array_reverse($triada); // разворачиваем массив для операций
        if (isset($triada[1]) && $triada[1] == 1) { // строго для 10-19
            $triada[0] = $triada[1] . $triada[0]; // Объединяем в единицы
            $triada[1] = ''; // убиваем десятки
            $triada[0] = self::$_1_19[$triada[0]]; // присваиваем
        } else { // а дальше по обычной схеме
            if (isset($case) && ($triada[0] == 1 || $triada[0] == 2)) { // если требуется м.р.
                $triada[0] = self::$_1_2[$triada[0]]; // единицы, массив мужского рода
            } else {
                if ($triada[0] != 0) {
                    $triada[0] = self::$_1_19[$triada[0]];
                } else {
                    $triada[0] = '';
                } // единицы
            } # if
            if (isset($triada[1]) && $triada[1] != 0) {
                $triada[1] = self::$des[$triada[1]];
            } else {
                $triada[1] = '';
            } // десятки
        }
        if (isset($triada[2]) && $triada[2] != 0) {
            $triada[2] = self::$hang[$triada[2]];
        } else {
            $triada[2] = '';
        } // сотни
        $triada = array_reverse($triada); // разворачиваем массив для вывода
        foreach ($triada as $triada_) { // вычищаем массив от пустых значений
            if ($triada_ != '') {
                $triada1[] = $triada_;
            }
        } # foreach
        return $triada1;
    }

    private static function Currency($amount) {
        $last2 = substr($amount, -2); // последние 2 цифры
        $last1 = substr($amount, -1); // последняя 1 цифра
        $last3 = substr($amount, -3); //последние 3 цифры
        if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5 || $last3 == '000') {
            $curr = self::$namecurr[3];
        } // от 10 до 19
        else if ($last1 == 1) {
            $curr = self::$namecurr[1];
        } // для 1-цы
        else {
            $curr = self::$namecurr[2];
        } // все остальные 2, 3, 4
        return ' ' . $curr;
    }

    private static function GetNum($level, $amount) {
        if ($level == 1) {
            $num_arr = null;
        } else if ($level == 2) {
            $num_arr = self::$nametho;
        } else if ($level == 3) {
            $num_arr = self::$namemil;
        } else if ($level == 4) {
            $num_arr = self::$namemrd;
        } else {
            $num_arr = null;
        }
        if (isset($num_arr)) {
            $last2 = substr($amount, -2);
            $last1 = substr($amount, -1);
            if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5) {
                $res_num = $num_arr[3];
            } // 10-19
            else if ($last1 == 1) {
                $res_num = $num_arr[1];
            } // для 1-цы
            else {
                $res_num = $num_arr[2];
            } // все остальные 2, 3, 4
            return ' ' . $res_num;
        } # if
    }
    /*

    */

}