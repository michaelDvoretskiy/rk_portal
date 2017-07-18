<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;

class  TradeZoneRepository extends EntityRepository {
    public function generateKod() {
//        $res = $this->getEntityManager("kvint")
//            ->createQuery("select max(t.kod) as k from KvintBundle:TradeZone t")
//            ->getResult();
//        $kod = $res[0]["k"];
//        if (is_null($kod)) {
//            $kod = 0;
//        }
//        $kod++;
//        return $kod;
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:TradeZone");
    }
}