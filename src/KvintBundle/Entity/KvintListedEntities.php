<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 20.07.2017
 * Time: 9:44
 */

namespace KvintBundle\Entity;


class KvintListedEntities
{
    public static function Prices() {
        return [
            'Дисконтная' => '1', 'Розничная' => '2', 'Оптовая' => '3', 'Пенсионная' => '4', 'Общепит' => '5', 'Сотрудник' => '6',
        ];
    }

    public static function emptyFieldForChoice() {
        return ['id' => 0, 'text' => 'Не выбран'];
    }
}