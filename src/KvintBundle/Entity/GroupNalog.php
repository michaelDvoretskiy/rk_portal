<?php

namespace KvintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name = "grnalog")
 */
class GroupNalog {

    /**
     * @ORM\Id()
     * @ORM\Column(name="kod", type="integer")
     */
    protected $kod;

    /**
     * @ORM\Column(name="gname", type="string", length=30)
     */
    protected $name;

    /**
     * @ORM\Column(name = "stavka", type = "decimal", length = 5, scale = 2)
     */
    protected $persent;

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

    /**
     * @return mixed
     */
    public function getPersent()
    {
        return $this->persent;
    }

    /**
     * @param mixed $persent
     */
    public function setPersent($persent)
    {
        $this->persent = $persent;
        return $this;
    }
}