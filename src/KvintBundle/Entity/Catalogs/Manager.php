<?php

namespace KvintBundle\Entity\Catalogs;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KvintBundle\Entity\KvintListedEntities;
use KvintBundle\Entity\KvintTypeConverter;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\ManagerRepository")
 * @ORM\Table(name = "manager")
 */
class Manager {

    /**
     * @ORM\Id()
     * @ORM\Column(name="kod", type="integer")
     */
    protected $kod;

    /**
     * @ORM\Column(name = "mname", length = 40)
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getKod()
    {
        return $this->kod;
    }

    /**
     * @param mixed $kod
     */
    public function setKod($kod)
    {
        $this->kod = $kod;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function initEmptyForChoice() {
        $arr = KvintListedEntities::emptyFieldForChoice();
        $this->setKod($arr['id']);
        $this->setName($arr['text']);
        return $this;
    }
}