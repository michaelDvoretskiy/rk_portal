<?php
namespace KvintBundle\Entity;

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
     * @ORM\Column(name="IsObpRozn", type="string", length=1)
     */
    protected $obpRozn;

    /**
     * @ORM\Column(name="AutoClose", type="string", length=1)
     */
    protected $autoClose;

    /**
     * @ORM\ManyToOne(targetEntity="Ent", inversedBy="skladList")
     * @ORM\JoinColumn(name="ekod", referencedColumnName="kod")
     */
    protected $entKod;

    /**
     * @ORM\ManyToOne(targetEntity="TradeZone", inversedBy="skladList")
     * @ORM\JoinColumn(name="kodZone", referencedColumnName="kod")
     */
    protected $zoneKod;

    /**
     * @return mixed
     */
    public function getZoneKod()
    {
        return $this->zoneKod;
    }

    /**
     * @param mixed $zoneKod
     */
    public function setZoneKod($zoneKod)
    {
        $this->zoneKod = $zoneKod;
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
//        if ($this->rozn == "T") {
//            return true;
//        }
//        return false;
        return KvintTypeConverter::TFasBOOL($this->rozn);
    }

    /**
     * @param mixed $rozn
     */
    public function setRozn($rozn)
    {
//        if ($rozn) {
//            $this->rozn = "T";
//        } else {
//            $this->rozn = "F";
//            $this->setObpRozn(false);
//        }

        $this->rozn =  KvintTypeConverter::BOOLasTF($rozn);
        if (!$rozn) {
            $this->setObpRozn(false);
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function isObpRozn()
    {
//        if ($this->obpRozn == "T") {
//            return true;
//        }
//        return false;
        return KvintTypeConverter::TFasBOOL($this->obpRozn);
    }

    /**
     * @param mixed $isObpRozn
     */
    public function setObpRozn($obpRozn)
    {
//        if ($obpRozn && $this->isRozn()) {
//            $this->obpRozn = "T";
//        } else {
//            $this->obpRozn = "F";
//        }
        $this->obpRozn =  KvintTypeConverter::BOOLasTF($obpRozn && $this->isRozn());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutoClose()
    {
        if (is_null($this->autoClose)) {
            return "F";
        }
        return $this->autoClose;
    }

    /**
     * @param mixed $autoClose
     */
    public function setAutoClose($autoClose)
    {
        $this->autoClose = $autoClose;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntKod()
    {
        return $this->entKod;
    }

    /**
     * @param mixed $entKod
     */
    public function setEntKod($entKod)
    {
        $this->entKod = $entKod;
    }

    public static function getElementAll() {
        return (new self())->setKod(0)->setSname("Все склады");
    }
}
