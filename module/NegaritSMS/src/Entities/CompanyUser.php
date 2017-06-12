<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 1:18 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_users")
 */

class CompanyUser extends BaseTable
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
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @var Company $company
     */
    protected $company;

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



    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'user'=>$this->getUser()->getArray(),
            'company'=>$this->getCompany()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}