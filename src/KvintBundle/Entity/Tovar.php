<?php

namespace KvintBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass = "KvintBundle\Repository\TovarRepository")
 * @ORM\Table(name = "tovar")
 */
class Tovar
{
    /**
     * @ORM\Id()
     * @ORM\Column(name = "kod", type = "integer")
     */
    protected $kod;

    /**
     * @ORM\Column(length = 70)
     */
    protected $tname;

    /**
     * @ORM\Column(name = "pr1", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge1;

    /**
     * @ORM\Column(name = "fa1", length = 1)
     */
    protected $flagAutoExtraCharge1;

    /**
     * @ORM\Column(name = "pr2", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge2;

    /**
     * @ORM\Column(name = "fa2", length = 1)
     */
    protected $flagAutoExtraCharge2;

    /**
     * @ORM\Column(name = "pr3", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge3;

    /**
     * @ORM\Column(name = "fa3", length = 1)
     */
    protected $flagAutoExtraCharge3;

    /**
     * @ORM\Column(name = "pr4", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge4;

    /**
     * @ORM\Column(name = "fa4", length = 1)
     */
    protected $flagAutoExtraCharge4;

    /**
     * @ORM\Column(name = "pr5", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge5;

    /**
     * @ORM\Column(name = "fa5", length = 1)
     */
    protected $flagAutoExtraCharge5;

    /**
     * @ORM\Column(name = "pr6", type = "decimal", length = 5, scale = 2)
     */
    protected $percentAutoExtraCharge6;

    /**
     * @ORM\Column(name = "fa6", length = 1)
     */
    protected $flagAutoExtraCharge6;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\GroupTovar")
     * @ORM\JoinColumn(name = "grouptovar")
     */
    protected $groupTovar;

    /**
     * @return mixed
     */
    public function getGroupTovar()
    {
        return $this->groupTovar;
    }

    /**
     * @param mixed $groupTovar
     */
    public function setGroupTovar($groupTovar)
    {
        $this->groupTovar = $groupTovar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge1()
    {
        return $this->percentAutoExtraCharge1;
    }

    /**
     * @param mixed $percentAutoExtraCharge1
     */
    public function setPercentAutoExtraCharge1($percentAutoExtraCharge1)
    {
        $this->percentAutoExtraCharge1 = $percentAutoExtraCharge1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge2()
    {
        return $this->percentAutoExtraCharge2;
    }

    /**
     * @param mixed $percentAutoExtraCharge2
     */
    public function setPercentAutoExtraCharge2($percentAutoExtraCharge2)
    {
        $this->percentAutoExtraCharge2 = $percentAutoExtraCharge2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge3()
    {
        return $this->percentAutoExtraCharge3;
    }

    /**
     * @param mixed $percentAutoExtraCharge3
     */
    public function setPercentAutoExtraCharge3($percentAutoExtraCharge3)
    {
        $this->percentAutoExtraCharge3 = $percentAutoExtraCharge3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge4()
    {
        return $this->percentAutoExtraCharge4;
    }

    /**
     * @param mixed $percentAutoExtraCharge4
     */
    public function setPercentAutoExtraCharge4($percentAutoExtraCharge4)
    {
        $this->percentAutoExtraCharge4 = $percentAutoExtraCharge4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge5()
    {
        return $this->percentAutoExtraCharge5;
    }

    /**
     * @param mixed $percentAutoExtraCharge5
     */
    public function setPercentAutoExtraCharge5($percentAutoExtraCharge5)
    {
        $this->percentAutoExtraCharge5 = $percentAutoExtraCharge5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentAutoExtraCharge6()
    {
        return $this->percentAutoExtraCharge6;
    }

    /**
     * @param mixed $percentAutoExtraCharge6
     */
    public function setPercentAutoExtraCharge6($percentAutoExtraCharge6)
    {
        $this->percentAutoExtraCharge6 = $percentAutoExtraCharge6;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge1()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge1);
    }

    /**
     * @param mixed $flagAutoExtraCharge1
     */
    public function setFlagAutoExtraCharge1($flagAutoExtraCharge1)
    {
        $this->flagAutoExtraCharge1 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge1);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge2()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge2);
    }

    /**
     * @param mixed $flagAutoExtraCharge2
     */
    public function setFlagAutoExtraCharge2($flagAutoExtraCharge2)
    {
        $this->flagAutoExtraCharge2 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge2);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge3()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge3);
    }

    /**
     * @param mixed $flagAutoExtraCharge3
     */
    public function setFlagAutoExtraCharge3($flagAutoExtraCharge3)
    {
        $this->flagAutoExtraCharge3 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge3);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge4()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge4);
    }

    /**
     * @param mixed $flagAutoExtraCharge1
     */
    public function setFlagAutoExtraCharge4($flagAutoExtraCharge4)
    {
        $this->flagAutoExtraCharge4 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge4);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge5()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge5);
    }

    /**
     * @param mixed $flagAutoExtraCharge5
     */
    public function setFlagAutoExtraCharge5($flagAutoExtraCharge5)
    {
        $this->flagAutoExtraCharge5 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge5);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlagAutoExtraCharge6()
    {
        return KvintTypeConverter::TFasBOOL($this->flagAutoExtraCharge6);
    }

    /**
     * @param mixed $flagAutoExtraCharge1
     */
    public function setFlagAutoExtraCharge6($flagAutoExtraCharge6)
    {
        $this->flagAutoExtraCharge6 = KvintTypeConverter::BOOLasTF($flagAutoExtraCharge6);
        return $this;
    }

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
    public function getTname()
    {
        return $this->tname;
    }

    /**
     * @param mixed $tname
     */
    public function setTname($tname)
    {
        $this->tname = $tname;
        return $this;
    }
}