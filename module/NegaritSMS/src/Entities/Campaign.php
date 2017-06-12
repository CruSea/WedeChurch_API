<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 2:50 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="campaign",uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "company_id"})})
 */
class Campaign extends BaseTable
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
     * @ORM\ManyToOne(targetEntity="SMSPort")
     * @ORM\JoinColumn(name="sms_port_id", referencedColumnName="id")
     * @var SMSPort $SMSPort
     */
    protected $SMSPort;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=false)
     */
    protected $description;

    protected $campaignUsers;

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
     * @return SMSPort
     */
    public function getSMSPort()
    {
        return $this->SMSPort;
    }

    /**
     * @param SMSPort $SMSPort
     */
    public function setSMSPort($SMSPort)
    {
        $this->SMSPort = $SMSPort;
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

    /**
     * @return mixed
     */
    public function getCampaignUsers()
    {
        if($this->campaignUsers){
            return $this->campaignUsers;
        }else{
            return "";
        }
    }

    /**
     * @param mixed $campaignUsers
     */
    public function setCampaignUsers($campaignUsers)
    {
        $this->campaignUsers = $campaignUsers;
    }

    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'name'=>$this->getName(),
            'company'=>$this->getCompany()->getArray(),
            'sms_port'=>$this->getSMSPort()->getArray(),
            'description'=>$this->getDescription(),
            'campaign_users'=>$this->getCampaignUsers(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}