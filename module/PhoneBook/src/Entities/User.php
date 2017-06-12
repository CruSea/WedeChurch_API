<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:51 AM
 */

namespace PhoneBook\Entities;
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
     * @ORM\Column(name="full_name", type="string", unique=false, nullable=false)
     */
    protected $fullName;
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


    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'user_name'=>$this->getUserName(),
            'full_name'=>$this->getFullName(),
            'privilege'=>$this->getPrivilege()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}