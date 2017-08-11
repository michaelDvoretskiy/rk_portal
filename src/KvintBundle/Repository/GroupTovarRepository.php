<?php
/**
 * Created by PhpStorm.
 * User: M_Dvoretskiy
 * Date: 09.08.2017
 * Time: 16:14
 */

namespace KvintBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KvintBundle\Entity\GroupTovar;

class GroupTovarRepository  extends EntityRepository {

    public function generateKod() {
        return KvintCodeGetter::getCode($this->getEntityManager("kvint"), "KvintBundle:GroupTovar");
    }

    public function getSubgroups(GroupTovar $grp) {
        $q = $this->getEntityManager("kvint")->createQuery("select g from KvintBundle:GroupTovar where g.gname = :gname order by g.gname2");
        $q->setParameter("gname", $grp->getGname());
        return $q->getResult();
    }

    public function getGroups() {
        $q = $this->getEntityManager("kvint")->createQuery("select g from KvintBundle:GroupTovar g where g.gname2 is null or g.gname2 = '' or g.gname2 like ' %' order by g.gname");
        return $q->getResult();
    }

    public function getGroupsWithAllFirst() {
        $res = $this->getGroups();
        $grpAll = (new GroupTovar())->setKod(0)->setGname("Все группы")->setGname2("");

        array_unshift($res, $grpAll);

        return $res;
    }
}