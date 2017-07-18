<?php

namespace KvintBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="klient")
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
     * ORM\Column(name = "fullname", type = "string", length = 150)
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
    protected $ediniyNalog;

    /**
     * @ORM\Column(name = "flCP", type = "string", length = 1)
     */
    protected $fisLitso;

    /**
     * @ORM\Column(name = "kFil", type = "string", length = 4)
     */
    protected $filial;

    /**
     * @ORM\Column(name = "ddog", type = "date")
     */
    protected $dogovor_data;

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
    }

    /**
     * @return mixed
     */
    public function getEdiniyNalog()
    {
        return $this->ediniyNalog;
    }

    /**
     * @param mixed $ediniyNalog
     */
    public function setEdiniyNalog($ediniyNalog)
    {
        $this->ediniyNalog = $ediniyNalog;
    }

    /**
     * @return mixed
     */
    public function getFisLitso()
    {
        return $this->fisLitso;
    }

    /**
     * @param mixed $fisLitso
     */
    public function setFisLitso($fisLitso)
    {
        $this->fisLitso = $fisLitso;
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
    }

    /**
     * @return mixed
     */
    public function getDogovorData()
    {
        return $this->dogovor_data;
    }

    /**
     * @param mixed $dogovor_data
     */
    public function setDogovorData($dogovor_data)
    {
        $this->dogovor_data = $dogovor_data;
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
        return $this->price_num;
    }

    /**
     * @param mixed $price_num
     */
    public function setPriceNum($price_num)
    {
        $this->price_num = $price_num;
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
}