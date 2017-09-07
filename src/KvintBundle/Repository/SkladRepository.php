<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\Sklad;

class SkladRepository extends EntityRepository {
    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Sklad");
    }

    public function getList() {
        $q = $this->getEntityManager("kvint")->createQuery("select s from KvintBundle:Sklad s order by s.sname");
        return $q->getResult();
    }

    public function getListWithAllFirst() {
        $res = $this->getList();
        array_unshift($res, Sklad::getElementAll());

        return $res;
    }
}