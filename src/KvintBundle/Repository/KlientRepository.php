<?php

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;

class KlientRepository extends EntityRepository {
    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Klient");
    }
}