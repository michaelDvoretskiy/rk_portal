<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rk_portal_groups")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Right", mappedBy="group")
     */
    protected $rights;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocRight", mappedBy="group")
     */
    protected $docRights;

    public function __construct()
    {
        parent::__construct("");
        $this->rights = new ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * @return ArrayCollection
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param ArrayCollection $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }

    /**
     * @return mixed
     */
    public function getDocRights()
    {
        return $this->docRights;
    }

    /**
     * @param mixed $docRights
     */
    public function setDocRights($docRights)
    {
        $this->docRights = $docRights;
    }
}