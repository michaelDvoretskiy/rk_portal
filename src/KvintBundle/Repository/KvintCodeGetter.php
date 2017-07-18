<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 18.07.2017
 * Time: 9:06
 */

namespace KvintBundle\Repository;


use Doctrine\ORM\EntityManager;

class KvintCodeGetter
{
    public static function getCode(EntityManager $em, $entity, $field = "kod") {
        $res = $em->createQuery("select max(e." . $field . ") as k from " . $entity . " e")
            ->getResult();
        $kod = $res[0]["k"];
        if (is_null($kod)) {
            $kod = 0;
        }
        $kod++;
        return $kod;
    }
}