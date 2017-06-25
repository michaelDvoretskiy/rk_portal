<?php
namespace KvintBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\SkladRepository")
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
    protected $sname;

    /**
     * @ORM\Column(name="rozn", type="string", length=1)
     */
    protected $rozn;

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
        return $this;
    }

    /**
     * @param mixed $kod
     */
    public function setKod($kod) {
        $this->kod = $kod;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRozn()
    {
        if ($this->rozn == "T") {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $rozn
     */
    public function setRozn($rozn)
    {
        if ($rozn) {
            $this->rozn = "T";
        } else {
            $this->rozn = "F";
        }
        return $this;
    }
}
