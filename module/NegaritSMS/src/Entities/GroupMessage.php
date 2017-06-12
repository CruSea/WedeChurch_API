<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:42 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_messages")
 */
class GroupMessage extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="message", type="string", unique=false, nullable=false)
     */
    protected $message;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var Group $group
     */
    protected $group;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Campaign")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     * @var Campaign $campaign
     */
    protected $campaign;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
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

    /**
     * @return Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param Campaign $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'message'=>$this->getMessage(),
            'group'=>$this->getGroup()->getArray(),
            'campaign'=>$this->getCampaign()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getArray(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getArray(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}