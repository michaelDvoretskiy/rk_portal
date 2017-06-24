<?php
namespace KvintBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sklad")
 */
class Sklad {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="kod")
     */
    protected $kod;

    /**
     * @ORM\Column(name="sname", type="string", length=30)
     */
    private $sname;

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
    public function getSname()
    {
        return $this->sname;
    }

    /**
     * @param mixed $sname
     */
    public function setSname($sname)
    {
        $this->sname = $sname;
    }

}