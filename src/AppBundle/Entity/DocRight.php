<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rk_portal_documents_rights")
 */
class DocRight
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
     * @ORM\Column(name = "change_status", type = "boolean", nullable=true)
     */
    protected $changeStatus;

    /**
     * @ORM\Column(name = "view_changes_journal", type = "boolean", nullable=true)
     */
    protected $viewChangesJournal;

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
    public function isChangeStatus()
    {
        return $this->changeStatus;
    }

    /**
     * @param mixed $changeStatus
     */
    public function setChangeStatus($changeStatus)
    {
        $this->changeStatus = $changeStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isViewChangesJournal()
    {
        return $this->viewChangesJournal;
    }

    /**
     * @param mixed $viewChangesJournal
     */
    public function setViewChangesJournal($viewChangesJournal)
    {
        $this->viewChangesJournal = $viewChangesJournal;
        return $this;
    }

}