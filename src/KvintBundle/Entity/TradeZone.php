<?php

namespace KvintBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="temp_spr_zones")
 */
class TradeZone {
    /**
     * @ORM\Id()
     * @ORM\Column(name="kod", type="smallint")
     */
    protected $kod;

    /**
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="KvintBundle\Entity\Sklad", mappedBy="zoneKod")
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
}
