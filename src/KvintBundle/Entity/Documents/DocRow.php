<?php

namespace KvintBundle\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\Documents\DocRowRepository")
 * @ORM\Table(name = "RABSOD")
 */
class DocRow {

    /**
     * @ORM\Id()
     * @ORM\Column(name = "rowid", type = "integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Klient")
     * @ORM\JoinColumn(name = "prt", referencedColumnName = "kod", nullable = true)
     */
    protected $supplier;

    /**
     * @ORM\ManyToOne(targetEntity="KvintBundle\Entity\Documents\GoodsMovingDocument", inversedBy="rows")
     * @ORM\JoinColumn(name = "kod", referencedColumnName = "kod")
     */
    protected $document;

    /**
     * @ORM\ManyToOne(targetEntity="KvintBundle\Entity\Tovar")
     * @ORM\JoinColumn(name = "kodtov", referencedColumnName = "kod")
     */
    protected $tovar;

    /**
     * @ORM\Column(name = "kolpr", type = "decimal", precision = 15, scale = 3)
     */
    protected $incomeQuantity;

    /**
     * @ORM\Column(name = "kolrs", type = "decimal", precision = 15, scale = 3)
     */
    protected $outcomeQuantity;

    /**
     * @ORM\Column(name = "cu", type = "decimal", precision = 15, scale = 6)
     */
    protected $costPrice;

    /**
     * @ORM\Column(name = "co", type = "decimal", precision = 15, scale = 6)
     */
    protected $salePrice;

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIncomeQuantity()
    {
        return $this->incomeQuantity;
    }

    /**
     * @param mixed $incomeQuantity
     */
    public function setIncomeQuantity($incomeQuantity)
    {
        $this->incomeQuantity = $incomeQuantity;
    }

    /**
     * @return mixed
     */
    public function getOutcomeQuantity()
    {
        return $this->outcomeQuantity;
    }

    /**
     * @param mixed $outcomeQuantity
     */
    public function setOutcomeQuantity($outcomeQuantity)
    {
        $this->outcomeQuantity = $outcomeQuantity;
    }

    /**
     * @return mixed
     */
    public function getCostPrice()
    {
        return $this->costPrice;
    }

    /**
     * @param mixed $costPrice
     */
    public function setCostPrice($costPrice)
    {
        $this->costPrice = $costPrice;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * @param mixed $salePrice
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;
    }
}