<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/3/17
 * Time: 9:14 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="forgot_passwords")
 */

class ForgotPassword extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User $user
     */
    protected $user;
    /**
     * @ORM\Column(name="reset_code", type="string", unique=false, nullable=false)
     */
    protected $resetCode;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getResetCode()
    {
        return $this->resetCode;
    }

    /**
     * @param mixed $resetCode
     */
    public function setResetCode($resetCode)
    {
        $this->resetCode = $resetCode;
    }
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'user'=>$this->getUser()->getArray(),
            'reset_code'=>$this->getResetCode(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}