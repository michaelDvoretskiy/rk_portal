<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="rk_portal_users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity = "AppBundle\Entity\Group")
     * @ORM\JoinTable(name = "rk_portal_users_groups",
     *     joinColumns={@ORM\JoinColumn(name = "user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name = "group_id", referencedColumnName="id")}
     *     )
     */
    protected $groups;

    public function __construct()
    {
        parent::__construct();
    }
}