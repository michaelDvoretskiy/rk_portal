<?php

namespace KvintBundle\Entity\Documents;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KvintBundle\Entity\KvintTypeConverter;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name = "typd", type = "integer")
 * @ORM\DiscriminatorMap({0 = "GoodsMovingDocument", 1 = "IncomeDocument", 2 = "ExpenseDocument"})
 * @ORM\Table(name="RABFOLD")
 */
class GoodsMovingDocument {

    /**
     * @ORM\Id()
     * @ORM\Column(name="kod", type="integer")
     */
    protected $kod;

    /**
     * @ORM\Column(name = "num", length = 10)
     */
    protected $number;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Sklad")
     * @ORM\JoinColumn(name = "sklad", referencedColumnName = "kod")
     */
    protected $wareHouse;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Sklad")
     * @ORM\JoinColumn(name = "tosklad", referencedColumnName = "kod")
     */
    protected $toWareHouse;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Klient")
     * @ORM\JoinColumn(name = "klkod", referencedColumnName = "kod")
     */
    protected $customer;

    /**
     * @ORM\Column(name = "PNDS", type = "decimal", precision = 8, scale = 2)
     */
    protected $percentOfNDS;

    /**
     * @ORM\Column(name = "SU", type = "decimal", precision = 15, scale = 3)
     */
    protected $sumOfCostPrice;

    /**
     * @ORM\Column(name = "SO", type = "decimal", precision = 15, scale = 3)
     */
    protected $sumOfSalePrice;

    /**
     * @ORM\Column(name = "SNDS", type = "decimal", precision = 15, scale = 3)
     */
    protected $sumOfNDS;

    /**
     * @ORM\Column(name = "STARA", type = "decimal", precision = 15, scale = 3)
     */
    protected $sumOfTara;

    /**
     * @ORM\Column(name = "TRS", type = "decimal", precision = 15, scale = 3)
     */
    protected $sumOfFare;

//    /**
//     * @ORM\Column(name = "datadok", type = "string")
//     */
//    protected $docDateStr;

    /**
     * @ORM\Column(name = "datadok", type = "datetime_sql2000")
     */
    protected $docDate;

    /**
     * @ORM\Column(name = "srok", type = "datetime_sql2000")
     */
    protected $termOfPayment;

    /**
     * @ORM\Column(name = "dov", length = 30)
     */
    protected $proxyPaper;

    /**
     * @ORM\Column(name = "cheres", length = 40)
     */
    protected $proxyPerson;

    /**
     * @ORM\Column(name = "osnov", length = 40)
     */
    protected $basis;

    /**
     * @ORM\Column(name = "PROV", length = 1)
     */
    protected $status;

    /**
     * @ORM\Column(name = "FLOCK", length = 1)
     */
    protected $locked;

    /**
     * @ORM\Column(name = "FNN", length = 1)
     */
    protected $flagOfTaxDoc;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Catalogs\Manager")
     * @ORM\JoinColumn(name = "kman", referencedColumnName = "kod")
     */
    protected $manager;

    /**
     * @ORM\Column(name = "ncena", type = "integer")
     */
    protected $numberOfPrice;

    /**
     * @ORM\Column(name = "nprod", type = "integer")
     */
    protected $numberOfSale;

    /**
     * @ORM\Column(name = "ff", length = 1)
     */
    protected $fasovkaFlag;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Catalogs\PaymentType")
     * @ORM\JoinColumn(name = "kodopl", referencedColumnName = "kod")
     */
    protected $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Catalogs\Cash")
     * @ORM\JoinColumn(name = "num_kas", referencedColumnName = "kassa")
     */
    protected $cashNumber;

    /**
     * @ORM\Column(name = "SumRozn", type = "decimal", precision = 15, scale = 2)
     */
    protected $sumByRetailPrices;

    /**
     * @ORM\Column(name = "SumObpRozn", type = "decimal", precision = 15, scale = 2)
     */
    protected $sumByObpRetailPrices;

    /**
     * @ORM\Column(name = "flED", length = 1)
     */
    protected $digitalInput;

    /**
     * @ORM\Column(name = "flInDok", length = 1)
     */
    protected $innerDocument;

    /**
     * @ORM\Column(name = "flEnProv", length = 1)
     */
    protected $allowedToPass;

    /**
     * @ORM\Column(name = "flHide", length = 1)
     */
    protected $hiddenDoc;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\Catalogs\Bank")
     * @ORM\JoinColumn(name = "kodbank", referencedColumnName = "kod")
     */
    protected $bank;

    /**
     * @ORM\Column(name = "flActs5", length = 1)
     */
    protected $excise5;

    /**
     * @ORM\Column(name = "belowCostPrice", length = 1)
     */
    protected $bellowCostPrice;

    /**
     * @ORM\Column(name = "flNewCO", length = 1)
     */
    protected $salesPriceNeedUpdate;

    /**
     * @ORM\OneToMany(targetEntity = "KvintBundle\Entity\Documents\DocRow", mappedBy = "document")
     */
    protected $rows;

    public function getRows() {
        return $this->rows;
    }

    public function setRows($rows) {
        $this->rows = $rows;
        return $this;
    }

    public function __construct()
    {
        $this->rows = new ArrayCollection();

        $this->docDate = new \DateTime();
        $this->setAllowedToPass(false);
        $this->setBellowCostPrice(false);
        $this->setDigitalInput(false);
        $this->setExcise5(false);
        $this->setFasovkaFlag(false);
        $this->setFlagOfTaxDoc(false);
        $this->setHiddenDoc(false);
        $this->setInnerDocument(false);
        $this->setLocked(false);
        $this->unPass();
    }

    public function pass() {
        $this->setStatus('T');
    }

    public function unPass() {
        $this->setStatus('F');
    }

    public function markDel() {
        $this->setStatus('D');
    }

    /**
     * @return mixed
     */
    public function getTermOfPayment()
    {
        return $this->termOfPayment;
    }

    /**
     * @param mixed $termOfPayment
     */
    public function setTermOfPayment($termOfPayment)
    {
        $this->termOfPayment = $termOfPayment;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getDocDate()
    {
        return $this->docDate;
    }

    /**
     * @param mixed $docDate
     */
    public function setDocDate($docDate)
    {
        $this->docDate = $docDate;
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getWareHouse()
    {
        return $this->wareHouse;
    }

    /**
     * @param mixed $wareHouse
     */
    public function setWareHouse($wareHouse)
    {
        $this->wareHouse = $wareHouse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToWareHouse()
    {
        return $this->toWareHouse;
    }

    /**
     * @param mixed $toWareHouse
     */
    public function setToWareHouse($toWareHouse)
    {
        $this->toWareHouse = $toWareHouse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentOfNDS()
    {
        return $this->percentOfNDS;
    }

    /**
     * @param mixed $percentOfNDS
     */
    public function setPercentOfNDS($percentOfNDS)
    {
        $this->percentOfNDS = $percentOfNDS;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOfCostPrice()
    {
        return $this->sumOfCostPrice;
    }

    /**
     * @param mixed $sumOfCostPrice
     */
    public function setSumOfCostPrice($sumOfCostPrice)
    {
        $this->sumOfCostPrice = $sumOfCostPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOfSalePrice()
    {
        return $this->sumOfSalePrice;
    }

    /**
     * @param mixed $sumOfSalePrice
     */
    public function setSumOfSalePrice($sumOfSalePrice)
    {
        $this->sumOfSalePrice = $sumOfSalePrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOfNDS()
    {
        return $this->sumOfNDS;
    }

    /**
     * @param mixed $sumOfNDS
     */
    public function setSumOfNDS($sumOfNDS)
    {
        $this->sumOfNDS = $sumOfNDS;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOfTara()
    {
        return $this->sumOfTara;
    }

    /**
     * @param mixed $sumOfTara
     */
    public function setSumOfTara($sumOfTara)
    {
        $this->sumOfTara = $sumOfTara;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOfFare()
    {
        return $this->sumOfFare;
    }

    /**
     * @param mixed $sumOfFare
     */
    public function setSumOfFare($sumOfFare)
    {
        $this->sumOfFare = $sumOfFare;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxyPaper()
    {
        return $this->proxyPaper;
    }

    /**
     * @param mixed $proxyPaper
     */
    public function setProxyPaper($proxyPaper)
    {
        $this->proxyPaper = $proxyPaper;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxyPerson()
    {
        return $this->proxyPerson;
    }

    /**
     * @param mixed $proxyPerson
     */
    public function setProxyPerson($proxyPerson)
    {
        $this->proxyPerson = $proxyPerson;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasis()
    {
        return $this->basis;
    }

    /**
     * @param mixed $basis
     */
    public function setBasis($basis)
    {
        $this->basis = $basis;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isLocked()
    {
        return KvintTypeConverter::TFasBOOL($this->locked);
    }

    /**
     * @param mixed $locked
     */
    public function setLocked($locked)
    {
        $this->locked = KvintTypeConverter::BOOLasTF($locked);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isFlagOfTaxDoc()
    {
        return KvintTypeConverter::TFasBOOL($this->flagOfTaxDoc);
    }

    /**
     * @param mixed $flagOfTaxDoc
     */
    public function setFlagOfTaxDoc($flagOfTaxDoc)
    {
        $this->flagOfTaxDoc = KvintTypeConverter::BOOLasTF($flagOfTaxDoc);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberOfPrice()
    {
        return $this->numberOfPrice;
    }

    /**
     * @param mixed $numberOfPrice
     */
    public function setNumberOfPrice($numberOfPrice)
    {
        $this->numberOfPrice = $numberOfPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberOfSale()
    {
        return $this->numberOfSale;
    }

    /**
     * @param mixed $numberOfSale
     */
    public function setNumberOfSale($numberOfSale)
    {
        $this->numberOfSale = $numberOfSale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isFasovkaFlag()
    {
        return KvintTypeConverter::TFasBOOL($this->fasovkaFlag);
    }

    /**
     * @param mixed $fasovkaFlag
     */
    public function setFasovkaFlag($fasovkaFlag)
    {
        $this->fasovkaFlag =  KvintTypeConverter::BOOLasTF($fasovkaFlag);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCashNumber()
    {
        return $this->cashNumber;
    }

    /**
     * @param mixed $cashNumber
     */
    public function setCashNumber($cashNumber)
    {
        $this->cashNumber = $cashNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumByRetailPrices()
    {
        return $this->sumByRetailPrices;
    }

    /**
     * @param mixed $sumByRetailPrices
     */
    public function setSumByRetailPrices($sumByRetailPrices)
    {
        $this->sumByRetailPrices = $sumByRetailPrices;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumByObpRetailPrices()
    {
        return $this->sumByObpRetailPrices;
    }

    /**
     * @param mixed $sumByObpRetailPrices
     */
    public function setSumByObpRetailPrices($sumByObpRetailPrices)
    {
        $this->sumByObpRetailPrices = $sumByObpRetailPrices;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDigitalInput()
    {
        return KvintTypeConverter::TFasBOOL($this->digitalInput);
    }

    /**
     * @param mixed $digitalInput
     */
    public function setDigitalInput($digitalInput)
    {
        $this->digitalInput =  KvintTypeConverter::BOOLasTF($digitalInput);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isInnerDocument()
    {
        return KvintTypeConverter::TFasBOOL($this->innerDocument);
    }

    /**
     * @param mixed $innerDocument
     */
    public function setInnerDocument($innerDocument)
    {
        $this->innerDocument =  KvintTypeConverter::BOOLasTF($innerDocument);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isAllowedToPass()
    {
        return KvintTypeConverter::TFasBOOL($this->allowedToPass);
    }

    /**
     * @param mixed $allowedToPass
     */
    public function setAllowedToPass($allowedToPass)
    {
        $this->allowedToPass =  KvintTypeConverter::BOOLasTF($allowedToPass);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isHiddenDoc()
    {
        return KvintTypeConverter::TFasBOOL($this->hiddenDoc);
    }

    /**
     * @param mixed $hiddenDoc
     */
    public function setHiddenDoc($hiddenDoc)
    {
        $this->hiddenDoc =  KvintTypeConverter::BOOLasTF($hiddenDoc);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param mixed $bank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isExcise5()
    {
        return KvintTypeConverter::TFasBOOL($this->excise5);
    }

    /**
     * @param mixed $excise5
     */
    public function setExcise5($excise5)
    {
        $this->excise5 =  KvintTypeConverter::BOOLasTF($excise5);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isBellowCostPrice()
    {
        return KvintTypeConverter::TFasBOOL($this->bellowCostPrice);
    }

    /**
     * @param mixed $bellowCostPrice
     */
    public function setBellowCostPrice($bellowCostPrice)
    {
        $this->bellowCostPrice =  KvintTypeConverter::BOOLasTF($bellowCostPrice);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isSalesPriceNeedUpdate()
    {
        return KvintTypeConverter::TFasBOOL($this->salesPriceNeedUpdate);
    }

    /**
     * @param mixed $bellowCostPrice
     */
    public function setSalesPriceNeedUpdate($salesPriceNeedUpdate)
    {
        $this->salesPriceNeedUpdate =  KvintTypeConverter::BOOLasTF($salesPriceNeedUpdate);
        return $this;
    }

    public function beforeUpdate() {
        if (!is_null($this->getCustomer()) && $this->getCustomer()->getKod() == 0) {
            $this->setCustomer(null);
        }
        if (!is_null($this->getManager()) && $this->getManager()->getKod() == 0) {
            $this->setManager(null);
        }
    }

    public function getDocTitle() {
        return "№ " . $this->number . " от " . $this->getDocDate()->format('d.m.Y');
    }
}