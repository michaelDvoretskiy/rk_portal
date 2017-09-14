<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 09.08.2017
 * Time: 16:14
 */

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\Catalogs\Manager;

class ManagerRepository  extends EntityRepository {

    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:Catalogs\Manager");
    }

    public function getManagers() {
        $q = $this->_em->createQuery("select m from KvintBundle:Catalogs\Manager m order by m.name");
        return $q->getResult();
    }

    public function getManagersWithEmpty() {
        $res = $this->getManagers();
        array_unshift($res, (new Manager())->initEmptyForChoice());
        return $res;
    }

}