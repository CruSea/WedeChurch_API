<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:39 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="grouped_contacts",uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"contact_id", "group_id"})})
 */

class GroupedContact extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * @var Contact $contact
     */
    protected $contact;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var Group $group
     */
    protected $group;

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
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'contact'=>$this->getContact()->getArray(),
            'group'=>$this->getGroup()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}