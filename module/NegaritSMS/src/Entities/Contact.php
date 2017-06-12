<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:33 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="contacts",uniqueConstraints={@ORM\UniqueConstraint(name="name_company_unique", columns={"company_id", "phone_number"})})
 */

class Contact extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @var Company $company
     */
    protected $company;
    /**
     * @ORM\Column(name="full_name", type="string", unique=false, nullable=false)
     */
    protected $fullName;
    /**
     * @ORM\Column(name="phone_number", type="string", unique=false, nullable=false)
     */
    protected $phoneNumber;
    /**
     * @ORM\Column(name="email", type="string", unique=false, nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(name="location", type="string", unique=false, nullable=true)
     */
    protected $location;
    /**
     * @ORM\Column(name="note", type="string", unique=false, nullable=true)
     */
    protected $note;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=true)
     */
    protected $description;

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
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'company'=>$this->getCompany()->getArray(),
            'full_name'=>$this->getFullName(),
            'phone_number'=>$this->getPhoneNumber(),
            'email'=>$this->getEmail(),
            'location'=>$this->getLocation(),
            'note'=>$this->getNote(),
            'description'=>$this->getDescription(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getArray(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getUpdatedBy()->getArray(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}