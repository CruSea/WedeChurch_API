<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:51 AM
 */

namespace WedeChurch\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="user_name", type="string", unique=true, nullable=false)
     */
    protected $userName;
    /**
     * @ORM\Column(name="user_pass", type="string", unique=false, nullable=false)
     */
    protected $userPass;
    /**
     * @ORM\Column(name="first_name", type="string", unique=false, nullable=false)
     */
    protected $firstName;
    /**
     * @ORM\Column(name="last_name", type="string", unique=false, nullable=false)
     */
    protected $lastName;
    /**
     * @ORM\Column(name="user_email", type="string", unique=true, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="country", type="string", unique=false, nullable=false)
     */
    protected $Country;
    /**
     * @ORM\Column(name="sex", type="string", unique=false, nullable=true)
     */
    protected $sex;
    /**
     * @ORM\Column(name="user_phone", type="string", unique=true, nullable=true)
     */
    protected $phone;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Privilege")
     * @ORM\JoinColumn(name="privilege_id", referencedColumnName="id")
     * @var Privilege $privilege
     */
    protected $privilege;

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
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserPass()
    {
        return $this->userPass;
    }

    /**
     * @param mixed $userPass
     */
    public function setUserPass($userPass)
    {
        $this->userPass = $userPass;
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * @param mixed $Country
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
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
     * @return Privilege
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param Privilege $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }



    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'user_name'=>$this->getUserName(),
            'first_name'=>$this->getFirstName(),
            'last_name'=>$this->getLastName(),
            'email'=>$this->getEmail(),
            'country'=>$this->getCountry(),
            'phone'=>$this->getPhone(),
            'sex' => $this ->getSex(),
            'privilege'=>$this->getPrivilege()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}