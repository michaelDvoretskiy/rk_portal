<?php

namespace KvintBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass = "KvintBundle\Repository\GroupTovarRepository")
 * @ORM\Table(name = "grouptov")
 */
class GroupTovar
{
    /**
     * @ORM\Id()
     * @ORM\Column(name = "kod", type = "integer")
     */
    protected $kod;

    /**
     * @ORM\Column(length = 30)
     */
    protected $gname;

    /**
     * @ORM\Column(length = 30)
     */
    protected $gname2;

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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGname()
    {
        return $this->gname;
    }

    /**
     * @param mixed $gname
     */
    public function setGname($gname)
    {
        $this->gname = $gname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGname2()
    {
        return $this->gname2;
    }

    /**
     * @param mixed $gname2
     */
    public function setGname2($gname2)
    {
        $this->gname2 = $gname2;
        return $this;
    }


}