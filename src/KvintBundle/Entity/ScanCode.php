<?php

namespace KvintBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="dopscankod")
 */
class ScanCode {

    /**
     * @ORM\Id()
     * @ORM\Column(name = "id_Scan", length = 20)
     */
    protected $idScan;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Tovar")
     * @ORM\JoinColumn(name = "kod", referencedColumnName = "kod")
     */
    protected $kodtov;

    /**
     * @ORM\Column(name = "kol", type = "integer")
     */
    protected $quantity;

    /**
     * @return mixed
     */
    public function getIdScan()
    {
        return $this->idScan;
    }

    /**
     * @param mixed $idScan
     */
    public function setIdScan($idScan)
    {
        $this->idScan = $idScan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKodtov()
    {
        return $this->kodtov;
    }

    /**
     * @param mixed $kodtov
     */
    public function setKodtov($kodtov)
    {
        $this->kodtov = $kodtov;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
}