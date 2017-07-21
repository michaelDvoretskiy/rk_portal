<?php

namespace KvintBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\EntRepository")
 * @ORM\Table(name="sprent")
 */
class Ent {

    /**
     * @ORM\Id()
     * @ORM\Column(name="kod", type="integer")
     */
    protected $kod;

    /**
     * @ORM\Column(name="ename", type="string", length=60)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="KvintBundle\Entity\Sklad", mappedBy="entKod")
     */
    protected $skladList;

    function __construct()
    {
        $this->skladList = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getKod()
    {
        return $this->kod;
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
        return $this;
    }

    /**
     * @param mixed $kod
     */
    public function setKod($kod)
    {
        $this->kod = $kod;
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}