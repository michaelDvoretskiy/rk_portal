<?php

namespace KvintBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\KlientRepository")
 * @ORM\Table(name="klient")
 * @ORM\HasLifecycleCallbacks
 */
class Klient {
    /**
     * @ORM\Id
     * @ORM\Column(name = "kod")
     */
    protected $kod;

    /**
     * @ORM\Column(name = "kname", type = "string", length = 150)
     */
    protected $kname;

    /**
     * @ORM\Column(name = "fullname", type = "string", length = 150)
     */
    protected $fullName;

    /**
     * @ORM\Column(name = "reg", type = "string", length = 20)
     */
    protected $inn;

    /**
     * @ORM\Column(name = "bank", type = "string", length = 44)
     */
    protected $bank_name;

    /**
     * @ORM\Column(name = "okpo", type = "string", length = 15)
     */
    protected $bank_okpo;

    /**
     * @ORM\Column(name = "mfo", type = "string", length = 10)
     */
    protected $bank_mfo;

    /**
     * @ORM\Column(name = "scet", type = "string", length = 25)
     */
    protected $bank_schet;

    /**
     * @ORM\Column(name = "adres", type = "string", length = 150)
     */
    protected $address;

    /**
     * @ORM\Column(name = "telefon", type = "string", length = 30)
     */
    protected $telephone;

    /**
     * @ORM\Column(name = "flEN", type = "string", length = 1)
     */
    protected $ediniyNalog = 'F';

    /**
     * @ORM\Column(name = "flCP", type = "string", length = 1)
     */
    protected $fisLitso = 'F';

    /**
     * @ORM\Column(name = "kFil", type = "string", length = 4)
     */
    protected $filial;

    /**
     * @ORM\Column(name = "ddog", type = "string")
     */
    protected $dogovor_data;

    protected $dogovorDate;

    public function setDogovorDate($dogovorDate)
    {
        $this->dogovorDate = $dogovorDate;
//        if (!is_null($dogovorDate)) {
//            $this->dogovor_data = $dogovorDate->format("Y-m-d");
//        } else {
//            $this->dogovor_data = null;
//        }
        return $this;
    }

    public function getDogovorDate()
    {
        return $this->dogovorDate;
    }


    /**
     * @ORM\Column(name = "ndog", type = "string", length = 30)
     */
    protected $dogovor_number;

    /**
     * @ORM\Column(name = "viddog", type = "string", length = 50)
     */
    protected $dogovor_type;

    /**
     * @ORM\Column(name = "numcena", type = "smallint")
     */
    protected $price_num;

    /**
     * @ORM\Column(name = "email", type = "string", length = 50)
     */
    protected $email;

    /**
     * @ORM\Column(name = "opis", type = "string", length = 2096)
     */
    protected $additional_info;

    /**
     * @ORM\ManyToMany(targetEntity = "KvintBundle\Entity\Ent")
     * @ORM\JoinTable(name = "klt_ent",
     *     joinColumns={@ORM\JoinColumn(name = "klkod", referencedColumnName = "kod") },
     *     inverseJoinColumns={@ORM\JoinColumn(name = "ekod", referencedColumnName = "kod") }
     *     )
     */
    protected $org_list;

    /**
     * @return mixed
     */
    public function getKname()
    {
        return $this->kname;
    }

    /**
     * @param mixed $kname
     */
    public function setKname($kname)
    {
        $this->kname = $kname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * @param mixed $inn
     */
    public function setInn($inn)
    {
        $this->inn = $inn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * @param mixed $bank_name
     */
    public function setBankName($bank_name)
    {
        $this->bank_name = $bank_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankOkpo()
    {
        return $this->bank_okpo;
    }

    /**
     * @param mixed $bank_okpo
     */
    public function setBankOkpo($bank_okpo)
    {
        $this->bank_okpo = $bank_okpo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankMfo()
    {
        return $this->bank_mfo;
    }

    /**
     * @param mixed $bank_mfo
     */
    public function setBankMfo($bank_mfo)
    {
        $this->bank_mfo = $bank_mfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankSchet()
    {
        return $this->bank_schet;
    }

    /**
     * @param mixed $bank_schet
     */
    public function setBankSchet($bank_schet)
    {
        $this->bank_schet = $bank_schet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isEdiniyNalog()
    {
        return KvintTypeConverter::TFasBOOL($this->ediniyNalog);
    }

    /**
     * @param mixed $ediniyNalog
     */
    public function setEdiniyNalog($ediniyNalog)
    {
        $this->ediniyNalog = KvintTypeConverter::BOOLasTF($ediniyNalog);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isFisLitso()
    {
        return KvintTypeConverter::TFasBOOL($this->fisLitso);
    }

    /**
     * @param mixed $fisLitso
     */
    public function setFisLitso($fisLitso)
    {
        $this->fisLitso = KvintTypeConverter::BOOLasTF($fisLitso);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilial()
    {
        return $this->filial;
    }

    /**
     * @param mixed $filial
     */
    public function setFilial($filial)
    {
        $this->filial = $filial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDogovorData()
    {
        return substr($this->dogovor_data, 0, 10);
//
//        $timezone = new DateTimeZone("UTC");
//        $date = new DateTime(substr($this->dogovor_data, 0, 10), $timezone);
//        return $date->format("Y-m-d\TH:i:s");

        //return new \DateTime(substr($this->dogovor_data, 0, 10));
    }

    /**
     * @param mixed $dogovor_data
     */
    public function setDogovorData($dogovor_data)
    {
        $this->dogovor_data = substr($dogovor_data, 0, 10);
    }

    /**
     * @ORM\PostLoad
     */
    public function synchroAttr() {
        $this->dogovorDate = new \DateTime($this->dogovor_data);
    }

    /**
     * @ORM\PreUpdate
     */
    public function synchroAttr2() {
        if (!is_null($this->dogovorDate)) {
            $this->dogovor_data = $this->dogovorDate->format("Y-m-d");
        } else {
            $this->dogovor_data = null;
        }
    }

    /**
     * @return mixed
     */
    public function getDogovorNumber()
    {
        return $this->dogovor_number;
    }

    /**
     * @param mixed $dogovor_number
     */
    public function setDogovorNumber($dogovor_number)
    {
        $this->dogovor_number = $dogovor_number;
    }

    /**
     * @return mixed
     */
    public function getDogovorType()
    {
        return $this->dogovor_type;
    }

    /**
     * @param mixed $dogovor_type
     */
    public function setDogovorType($dogovor_type)
    {
        $this->dogovor_type = $dogovor_type;
    }

    /**
     * @return mixed
     */
    public function getPriceNum()
    {
        return KvintTypeConverter::NullToVal($this->price_num, 0);
    }

    /**
     * @param mixed $price_num
     */
    public function setPriceNum($price_num)
    {
        $this->price_num = KvintTypeConverter::ValToNull($price_num, 0);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAdditionalInfo()
    {
        return $this->additional_info;
    }

    /**
     * @param mixed $additional_info
     */
    public function setAdditionalInfo($additional_info)
    {
        $this->additional_info = $additional_info;
    }

    /**
     * @return mixed
     */
    public function getOrgList()
    {
        return $this->org_list;
    }

    /**
     * @param mixed $org_list
     */
    public function setOrgList($org_list)
    {
        $this->org_list = $org_list;
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
    }

    public function __construct()
    {
        $this->org_list = new ArrayCollection();
    }

    public function initEmptyForChoice() {
        $arr = KvintListedEntities::emptyFieldForChoice();
        $this->setKod($arr['id']);
        $this->setKname($arr['text']);
        return $this;
    }
}