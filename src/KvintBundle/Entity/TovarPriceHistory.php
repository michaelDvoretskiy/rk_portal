<?php

namespace KvintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\TovarPriceHistoryRepository")
 * @ORM\Table(name="sysgurnco")
 */
//its primary key needs to be extended.
// Now we can only insert new rows by using this entity
class TovarPriceHistory {

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Tovar")
     * @ORM\JoinColumn(name = "kod", referencedColumnName = "kod")
     */
    protected $tovar;

    /**
     * @ORM\Column(name = "uname", length = 25)
     */
    protected $userName;

    /**
     * @ORM\Column(name = "co1", type = "decimal", precision = 12, scale = 6)
     */
    protected $price1;

    /**
     * @ORM\Column(name = "co2", type = "decimal", precision = 12, scale = 6)
     */
    protected $price2;

    /**
     * @ORM\Column(name = "co3", type = "decimal", precision = 12, scale = 6)
     */
    protected $price3;

    /**
     * @ORM\Column(name = "co4", type = "decimal", precision = 12, scale = 6)
     */
    protected $price4;

    /**
     * @ORM\Column(name = "co5", type = "decimal", precision = 12, scale = 6)
     */
    protected $price5;

    /**
     * @ORM\Column(name = "co6", type = "decimal", precision = 12, scale = 6)
     */
    protected $price6;

    /**
     * @return mixed
     */
    public function getTovar()
    {
        return $this->tovar;
    }

    /**
     * @param mixed $tovar
     */
    public function setTovar($tovar)
    {
        $this->tovar = $tovar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice1()
    {
        return $this->price1;
    }

    /**
     * @param mixed $price1
     */
    public function setPrice1($price1)
    {
        $this->price1 = $price1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice2()
    {
        return $this->price2;
    }

    /**
     * @param mixed $price2
     */
    public function setPrice2($price2)
    {
        $this->price2 = $price2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice3()
    {
        return $this->price3;
    }

    /**
     * @param mixed $price3
     */
    public function setPrice3($price3)
    {
        $this->price3 = $price3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice4()
    {
        return $this->price4;
    }

    /**
     * @param mixed $price4
     */
    public function setPrice4($price4)
    {
        $this->price4 = $price4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice5()
    {
        return $this->price5;
    }

    /**
     * @param mixed $price5
     */
    public function setPrice5($price5)
    {
        $this->price5 = $price5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice6()
    {
        return $this->price6;
    }

    /**
     * @param mixed $price6
     */
    public function setPrice6($price6)
    {
        $this->price6 = $price6;
        return $this;
    }
}