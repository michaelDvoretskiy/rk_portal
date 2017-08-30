<?php

namespace KvintBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass = "KvintBundle\Repository\TovarRepository")
 * @ORM\Table(name = "tovar")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(length = 6)
     */
    protected $fasov;

    /**
     * @ORM\Column(name = "pr1", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge1;

    /**
     * @ORM\Column(name = "fa1", length = 1)
     */
    protected $flagAutoExtraCharge1;

    /**
     * @ORM\Column(name = "pr2", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge2;

    /**
     * @ORM\Column(name = "fa2", length = 1)
     */
    protected $flagAutoExtraCharge2;

    /**
     * @ORM\Column(name = "pr3", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge3;

    /**
     * @ORM\Column(name = "fa3", length = 1)
     */
    protected $flagAutoExtraCharge3;

    /**
     * @ORM\Column(name = "pr4", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge4;

    /**
     * @ORM\Column(name = "fa4", length = 1)
     */
    protected $flagAutoExtraCharge4;

    /**
     * @ORM\Column(name = "pr5", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge5;

    /**
     * @ORM\Column(name = "fa5", length = 1)
     */
    protected $flagAutoExtraCharge5;

    /**
     * @ORM\Column(name = "pr6", type = "decimal", precision = 5, scale = 2)
     */
    protected $percentAutoExtraCharge6;

    /**
     * @ORM\Column(name = "fa6", length = 1)
     */
    protected $flagAutoExtraCharge6;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\GroupTovar")
     * @ORM\JoinColumn(name = "grouptovar", referencedColumnName = "kod")
     */
    protected $groupTovar;

    /**
     * @ORM\Column(name = "co1", type = "decimal", precision = 15, scale = 6)
     */
    protected $price1;

    /**
     * @ORM\Column(name = "co2", type = "decimal", precision = 15, scale = 6)
     */
    protected $price2;

    /**
     * @ORM\Column(name = "co3", type = "decimal", precision = 15, scale = 6)
     */
    protected $price3;

    /**
     * @ORM\Column(name = "co4", type = "decimal", precision = 15, scale = 6)
     */
    protected $price4;

    /**
     * @ORM\Column(name = "co5", type = "decimal", precision = 15, scale = 6)
     */
    protected $price5;

    /**
     * @ORM\Column(name = "co6", type = "decimal", precision = 15, scale = 6)
     */
    protected $price6;

    /**
     * @ORM\ManyToOne(targetEntity = "KvintBundle\Entity\GroupNalog")
     * @ORM\JoinColumn(name = "GRNLG", referencedColumnName = "kod")
     */
    protected $groupNalog;

    /**
     * @ORM\Column(name = "nds", type = "decimal", precision = 8, scale = 2)
     */
    protected $nds;

    /**
     * @ORM\Column(name="act", type="string", length=1)
     */
    protected $active;

    /**
     * @ORM\Column(name="id_scan", length=24)
     */
    protected $idScan;

    /**
     * @ORM\Column(name="flConfKVED", type="string", length=1)
     */
    protected $kvedRight;

    /**
     * @ORM\Column(name="kved", length=20)
     */
    protected $kved;

    /**
     * @ORM\Column(name="FLIMP", type="string", length=1)
     */
    protected $import;

    /**
     * @ORM\Column(name = "dop", length = 20)
     */
    protected $dopName;

    /**
     * @ORM\Column(name = "optkol", type = "decimal", precision = 15, scale = 3)
     */
    protected $optQuantity;

    /**
     * @ORM\Column(name = "min_kol", type = "decimal", precision = 15, scale = 3)
     */
    protected $minQuantity;

    /**
     * @ORM\Column(name = "ves", type = "decimal", precision = 12, scale = 3)
     */
    protected $weight;

    /**
     * @ORM\Column(name = "ob", type = "decimal", precision = 15, scale = 3)
     */
    protected $volume;

    /**
     * @ORM\Column(name = "kolInUpak", type = "decimal", precision = 8, scale = 3)
     */
    protected $quantityInPack;

    /**
     * @ORM\Column(name = "tara", length = 1)
     */
    protected $returntara;

    /**
     * @ORM\Column(name = "nvtara", length = 1)
     */
    protected $unReturnTara;

    /**
     * @ORM\Column(name = "flGP", length = 1)
     */
    protected $makedProduction;

    /**
     * @ORM\Column(name = "flVesTov", length = 1)
     */
    protected $weightTovar;

    /**
     * @ORM\OneToOne(targetEntity="KvintBundle\Entity\Tovar")
     * @ORM\JoinColumn(name = "kodfas", referencedColumnName = "kod")
     */
    protected $tovarOfFasovka;

    /**
     * @ORM\Column(name = "kolfas", type = "decimal", precision = 7, scale = 3)
     */
    protected $quantityOfFasovka;

    /**
     * @ORM\Column(name = "flDisAN", length = 1)
     */
    protected $excludedFromExtra;

    /**
     * @ORM\Column(name = "flFisk", length = 1)
     */
    protected $fiscal;

    /**
     * @ORM\Column(name = "flNoDisk", length = 1)
     */
    protected $discountForbidden;

    /**
     * @ORM\Column(name = "ingradient", type = "string", length = 1500)
     */
    protected $additionalInfo;

    /**
     * @ORM\Column(name = "fl_indk", length = 1)
     */
    protected $manufacturerExtra;

    /**
     * @ORM\Column(name = "flIndA", length = 1)
     */
    protected $underExciseIndicative;

    /**
     * @ORM\Column(name = "flAcz", length = 1)
     */
    protected $excise;

    /**
     * @ORM\Column(name = "cena_pr", type = "decimal", precision = 12, scale = 3)
     */
    protected $manufacturerPrice;

    /**
     * @ORM\Column(name = "pr_indk", type = "decimal", precision = 5, scale = 3)
     */
    protected $manufacturerMaxExtra;

    /**
     * @ORM\Column(name = "cenaInd", type = "decimal", precision = 12, scale = 2)
     */
    protected $minimalPrice;

    /**
     * @return mixed
     */
    public function getManufacturerPrice()
    {
        return $this->manufacturerPrice;
    }

    /**
     * @param mixed $manufacturerPrice
     */
    public function setManufacturerPrice($manufacturerPrice)
    {
        $this->manufacturerPrice = $manufacturerPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getManufacturerMaxExtra()
    {
        return $this->manufacturerMaxExtra;
    }

    /**
     * @param mixed $manufacturerMaxExtra
     */
    public function setManufacturerMaxExtra($manufacturerMaxExtra)
    {
        $this->manufacturerMaxExtra = $manufacturerMaxExtra;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinimalPrice()
    {
        return $this->minimalPrice;
    }

    /**
     * @param mixed $minimalPrice
     */
    public function setMinimalPrice($minimalPrice)
    {
        $this->minimalPrice = $minimalPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @param mixed $additionalInfo
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isManufacturerExtra()
    {
        return KvintTypeConverter::TFasBOOL($this->manufacturerExtra);
    }

    /**
     * @param mixed $manufacturerExtra
     */
    public function setManufacturerExtra($manufacturerExtra)
    {
        $this->manufacturerExtra =  KvintTypeConverter::BOOLasTF($manufacturerExtra);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isUnderExciseIndicative()
    {
        return KvintTypeConverter::TFasBOOL($this->underExciseIndicative);
    }

    /**
     * @param mixed $underExciseIndicative
     */
    public function setUnderExciseIndicative($underExciseIndicative)
    {
        $this->underExciseIndicative =  KvintTypeConverter::BOOLasTF($underExciseIndicative);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isExcise()
    {
        return KvintTypeConverter::TFasBOOL($this->excise);
    }

    /**
     * @param mixed $excise
     */
    public function setExcise($excise)
    {
        $this->excise =  KvintTypeConverter::BOOLasTF($excise);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDiscountForbidden()
    {
        return KvintTypeConverter::TFasBOOL($this->discountForbidden);
    }

    /**
     * @param mixed $discountForbidden
     */
    public function setDiscountForbidden($discountForbidden)
    {
        $this->discountForbidden =  KvintTypeConverter::BOOLasTF($discountForbidden);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isFiscal()
    {
        return KvintTypeConverter::TFasBOOL($this->fiscal);
    }

    /**
     * @param mixed $fiscal
     */
    public function setFiscal($fiscal)
    {
        $this->fiscal =  KvintTypeConverter::BOOLasTF($fiscal);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isExcludedFromExtra()
    {
        return KvintTypeConverter::TFasBOOL($this->excludedFromExtra);
    }

    /**
     * @param mixed $excludedFromExtra
     */
    public function setExcludedFromExtra($excludedFromExtra)
    {
        $this->excludedFromExtra =  KvintTypeConverter::BOOLasTF($excludedFromExtra);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTovarOfFasovka()
    {
        return $this->tovarOfFasovka;
    }

    /**
     * @param mixed $tovarOfFasovka
     */
    public function setTovarOfFasovka($tovarOfFasovka)
    {
        if ((!is_null($tovarOfFasovka)) && ($tovarOfFasovka->getKod() == 0)) {
            $this->tovarOfFasovka = null;
            $this->quantityOfFasovka = null;
        } else {
            $this->tovarOfFasovka = $tovarOfFasovka;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantityOfFasovka()
    {
        return $this->quantityOfFasovka;
    }

    /**
     * @param mixed $quantityOfFasovka
     */
    public function setQuantityOfFasovka($quantityOfFasovka)
    {
        $this->quantityOfFasovka = $quantityOfFasovka;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isWeightTovar()
    {
        return KvintTypeConverter::TFasBOOL($this->weightTovar);
    }

    /**
     * @param mixed $weightTovar
     */
    public function setWeightTovar($weightTovar)
    {
        $this->weightTovar =  KvintTypeConverter::BOOLasTF($weightTovar);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isReturntara()
    {
        return KvintTypeConverter::TFasBOOL($this->returntara);
    }

    /**
     * @param mixed $returntara
     */
    public function setReturntara($returntara)
    {
        $this->returntara =  KvintTypeConverter::BOOLasTF($returntara);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isUnReturnTara()
    {
        return KvintTypeConverter::TFasBOOL($this->unReturnTara);
    }

    /**
     * @param mixed $unReturnTara
     */
    public function setUnReturnTara($unReturnTara)
    {
        $this->unReturnTara =  KvintTypeConverter::BOOLasTF($unReturnTara);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isMakedProduction()
    {
        return KvintTypeConverter::TFasBOOL($this->makedProduction);
    }

    /**
     * @param mixed $makedProduction
     */
    public function setMakedProduction($makedProduction)
    {
        $this->makedProduction =  KvintTypeConverter::BOOLasTF($makedProduction);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDopName()
    {
        return $this->dopName;
    }

    /**
     * @param mixed $dopName
     */
    public function setDopName($dopName)
    {
        $this->dopName = $dopName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptQuantity()
    {
        return $this->optQuantity;
    }

    /**
     * @param mixed $optQuantity
     */
    public function setOptQuantity($optQuantity)
    {
        $this->optQuantity = $optQuantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinQuantity()
    {
        return $this->minQuantity;
    }

    /**
     * @param mixed $minQuantity
     */
    public function setMinQuantity($minQuantity)
    {
        $this->minQuantity = $minQuantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantityInPack()
    {
        return $this->quantityInPack;
    }

    /**
     * @param mixed $quantityInPack
     */
    public function setQuantityInPack($quantityInPack)
    {
        $this->quantityInPack = $quantityInPack;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isKvedRight()
    {
        return KvintTypeConverter::TFasBOOL($this->kvedRight);
    }

    /**
     * @param mixed $kvedRight
     */
    public function setKvedRight($kvedRight)
    {
        $this->kvedRight =  KvintTypeConverter::BOOLasTF($kvedRight);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKved()
    {
        return $this->kved;
    }

    /**
     * @param mixed $kved
     */
    public function setKved($kved)
    {
        $this->kved = $kved;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isImport()
    {
        return KvintTypeConverter::TFasBOOL($this->import);
    }

    /**
     * @param mixed $import
     */
    public function setImport($import)
    {
        $this->import =  KvintTypeConverter::BOOLasTF($import);
        return $this;
    }

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
    public function isActive()
    {
        return KvintTypeConverter::TFasBOOL($this->active);
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active =  KvintTypeConverter::BOOLasTF($active);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupNalog()
    {
        return $this->groupNalog;
    }

    /**
     * @param mixed $groupNalog
     */
    public function setGroupNalog($groupNalog)
    {
        $this->groupNalog = $groupNalog;
        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getFasov()
    {
        return $this->fasov;
    }

    /**
     * @param mixed $fasov
     */
    public function setFasov($fasov)
    {
        $this->fasov = $fasov;
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

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateDef() {
        if (is_null($this->fasov)) {
            $this->fasov = '';
        }
        if (is_null($this->kvedRight)) {
            $this->kvedRight = 'F';
        }
        if (is_null($this->import)) {
            $this->import = 'F';
        }
        if (is_null($this->returntara)) {
            $this->returntara = 'F';
        }
        if (is_null($this->unReturnTara)) {
            $this->unReturnTara = 'F';
        }
        if (is_null($this->makedProduction)) {
            $this->makedProduction = 'F';
        }
        if (is_null($this->weightTovar)) {
            $this->weightTovar = 'F';
        }
        $this->nds = $this->groupNalog->getPersent();
        if (!is_null($this->getTovarOfFasovka()) && $this->getTovarOfFasovka() instanceof Tovar && $this->getTovarOfFasovka()->getKod() == 0) {
            $this->setTovarOfFasovka(null);
        }
    }

    public function initEmptyForChoice() {
        $arr = KvintListedEntities::emptyFieldForChoice();
        $this->setKod($arr['id']);
        $this->setTname($arr['text']);
        return $this;
    }
}