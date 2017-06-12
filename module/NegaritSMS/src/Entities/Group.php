<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:30 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups",uniqueConstraints={@ORM\UniqueConstraint(name="name_company_unique", columns={"company_id", "name"})})
 */
class Group extends BaseTable
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
     * @ORM\Column(name="name", type="string", unique=false, nullable=false)
     */
    protected $name;
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
            'name'=>$this->getName(),
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