<?php

namespace KvintBundle\Entity\Catalogs;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KvintBundle\Entity\KvintTypeConverter;

/**
 * @ORM\Entity()
 * @ORM\Table(name = "EuroPosKassa")
 */
class Cash {

    /**
     * @ORM\Id()
     * @ORM\Column(name="kassa", type="integer")
     */
    protected $kod;

    /**
     * @ORM\Column(name = "kname", length = 20)
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


}