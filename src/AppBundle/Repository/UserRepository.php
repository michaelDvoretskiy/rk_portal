<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;

class UserRepository extends EntityRepository
{
    public function checkRight(UserInterface $user, $entityName, $type) {
        $res = $this->getEntityManager("symf_portal")
            ->createQuery("select max(r." . $type . " * 1) allowed
                from AppBundle:User u join u.groups g left join g.rights r left join r.pEntity e
                where u.id = ?2 and e.name = ?3" )
            ->setParameter(2, $user->getId())
            ->setParameter(3, $entityName)
            ->getResult();
        $allowed = $res[0]["allowed"];
        if (is_null($allowed)) {
            $allowed = false;
        }
        return (boolean)$allowed;
    }

    public function getGeneralRights(UserInterface $user, $entityName) {
        $res = $this->getEntityManager("symf_portal")
            ->createQuery("select max(r.view * 1) a_view, max(r.add * 1) a_add, max(r.edit * 1) a_edit, max(r.delete * 1) a_delete 
                from AppBundle:User u join u.groups g left join g.rights r left join r.pEntity e
                where u.id = ?2 and e.name = ?3" )
            ->setParameter(2, $user->getId())
            ->setParameter(3, $entityName)
            ->getResult();
        return [
            'view' => $res[0]["a_view"],
            'add' => $res[0]["a_add"],
            'edit' => $res[0]["a_edit"],
            'delete' => $res[0]["a_delete"],
        ];
    }

    public function getDocRights(UserInterface $user, $entityName) {
        $res = $this->getEntityManager("symf_portal")
            ->createQuery("select max(r.viewChangesJournal * 1) journal  
                from AppBundle:User u join u.groups g left join g.docRights r left join r.pEntity e
                where u.id = ?2 and e.name = ?3" )
            ->setParameter(2, $user->getId())
            ->setParameter(3, $entityName)
            ->getResult();
        return [
            'journal' => $res[0]["journal"],
        ];
    }

    public function getRights(UserInterface $user, $entityName) {
        return array_merge($this->getGeneralRights($user, $entityName), $this->getDocRights($user, $entityName));
    }

    public function getRightsForLists(UserInterface $user) {
        $res = $this->getEntityManager("symf_portal")
            ->createQuery("select distinct e.name 
                from AppBundle:User u join u.groups g left join g.rights r left join r.pEntity e
                where u.id = ?1 and r.list = true")
            ->setParameter(1, $user->getId())
            ->getResult();
        $arr = [];
        foreach($res as $row) {
            $arr[] = $row['name'];
        }
        return $arr;

//        $res = $this->getEntityManager("symf_portal")->createQuery('select from AppBundle:right g join g.pen');

//        $res = $this->getEntityManager("symf_portal")->createQueryBuilder()
//            ->select('')
//            ->from('AppBundle:Group g');
    }
}