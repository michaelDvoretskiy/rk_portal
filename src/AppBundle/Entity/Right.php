<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rk_portal_rights")
 */
class Right
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PEntity", inversedBy="rights")
     * @ORM\JoinColumn(name="pentity_id", referencedColumnName="id")
     */
    protected $pEntity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group", inversedBy="rights")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\Column(name = "r_view", type = "boolean", nullable=true)
     */
    protected $view;

    /**
     * @ORM\Column(name = "r_edit", type = "boolean", nullable=true)
     */
    protected $edit;

    /**
     * @ORM\Column(name = "r_delete", type = "boolean", nullable=true)
     */
    protected $delete;

    /**
     * @ORM\Column(name = "r_add", type = "boolean", nullable=true)
     */
    protected $add;

    /**
     * @ORM\Column(name = "r_list", type = "boolean", nullable=true)
     */
    protected $list;

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPEntity()
    {
        return $this->pEntity;
    }

    /**
     * @param mixed $pEntity
     */
    public function setPEntity($pEntity)
    {
        $this->pEntity = $pEntity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isView()
    {
        return $this->view;
    }

    /**
     * @return mixed
     */
    public function isEdit()
    {
        return $this->edit;
    }

    /**
     * @return mixed
     */
    public function isDelete()
    {
        return $this->delete;
    }

    /**
     * @return mixed
     */
    public function isAdd()
    {
        return $this->add;
    }

    /**
     * @param mixed $view
     */
    public function setView($view)
    {
        $this->view = (bool) $view;
        return $this;
    }

    /**
     * @param mixed $edit
     */
    public function setEdit($edit)
    {
        $this->edit = (bool) $edit;
        return $this;
    }

    /**
     * @param mixed $delete
     */
    public function setDelete($delete)
    {
        $this->delete = (bool) $delete;
        return $this;
    }

    /**
     * @param mixed $add
     */
    public function setAdd($add)
    {
        $this->add = (bool) $add;
        return $this;
    }
}