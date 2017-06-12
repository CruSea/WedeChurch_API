<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 12:00 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Company extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string", unique=true, nullable=false)
     */
    protected $name;
    /**
     * @ORM\Column(name="email", type="string", unique=true, nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(name="phone", type="string", unique=true, nullable=true)
     */
    protected $phone;
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
            'name'=>$this->getName(),
            'email'=>$this->getEmail(),
            'phone'=>$this->getPhone(),
            'description'=>$this->getDescription(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}