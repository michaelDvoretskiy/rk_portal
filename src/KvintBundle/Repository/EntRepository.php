<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;

class  EntRepository extends EntityRepository {
    public function generateKod() {
//        $res = $this->getEntityManager("kvint")
//            ->createQuery("select max(e.kod) as k from KvintBundle:Ent e")
//            ->getResult();
//        $kod = $res[0]["k"];
//        if (is_null($kod)) {
//            $kod = 0;
//        }
//        $kod++;
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Ent");
    }
}