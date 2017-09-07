<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;

class KlientRepository extends EntityRepository {
    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Klient");
    }

    public function getListByName($text, $first = 1, $limit = 20) {
        $whereTxt = "k.kname like :text or k.bank_okpo like :text or k.inn like :text";
        $q = $this->_em->createQuery("select k.kod id, k.kname text from KvintBundle:Klient k where ". $whereTxt ." order by k.kname");
        $q->setParameter('text', "%".$text."%");
        $q->setFirstResult($first);
        $q->setMaxResults($limit);

        $q2 = $this->_em->createQuery("select count(k) c from KvintBundle:Klient k where ". $whereTxt);
        $q2->setParameter('text', "%".$text."%");
        return [$q->getArrayResult(), $q2->getArrayResult()];
    }
}