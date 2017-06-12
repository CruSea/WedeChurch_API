<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 3:42 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="sms_port",uniqueConstraints={@ORM\UniqueConstraint(name="name_company_unique", columns={"name", "company_id"})})
 */

class SMSPort extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string", unique=false, nullable=false)
     */
    protected $name;
    /**
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @var Company $company
     */
    protected $company;
    /**
     * @ORM\Column(name="phone", type="string", unique=false, nullable=false)
     */
    protected $phone;
    /**
     * @ORM\Column(name="secret", type="string", unique=false, nullable=false)
     */
    protected $secret;
    /**
     * @ORM\Column(name="device_id", type="string", unique=false, nullable=false)
     */
    protected $deviceID;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=false)
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
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getDeviceID()
    {
        return $this->deviceID;
    }

    /**
     * @param mixed $deviceID
     */
    public function setDeviceID($deviceID)
    {
        $this->deviceID = $deviceID;
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
            'company'=>$this->getCompany()->getArray(),
            'phone'=>$this->getPhone(),
            'description'=>$this->getDescription(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}