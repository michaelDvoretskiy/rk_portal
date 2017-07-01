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

    /*
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Right", mappedBy="pEntity")
     */
    protected $rights;

    public function __construct()
    {
        parent::__construct("");
        $this->rights = new ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }
}