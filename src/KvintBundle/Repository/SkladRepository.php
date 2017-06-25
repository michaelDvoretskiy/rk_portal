<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SkladRepository extends EntityRepository {
    public function generateKod() {
        $res = $this->getEntityManager("kvint")
            ->createQuery("select max(s.kod) as k from KvintBundle:Sklad s")
            ->getResult();
        $kod = $res[0]["k"];
        if (is_null($kod)) {
            $kod = 0;
        }
        $kod++;
        return $kod;
    }
}