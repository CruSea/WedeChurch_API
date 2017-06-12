<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 2:43 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="send_messages")
 */
class SendMessage extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="send_to", type="string", unique=false, nullable=false)
     */
    protected $sendTo;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Campaign")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     * @var Campaign $campaign
     */
    protected $campaign;
    /**
     * @ORM\Column(name="message", type="string", unique=false, nullable=false)
     */
    protected $message;
    /**
     * @ORM\Column(name="is_delivered", type="boolean", unique=false, nullable=false)
     */
    protected $isDelivered;

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
    public function getSendTo()
    {
        return $this->sendTo;
    }

    /**
     * @param mixed $sendTo
     */
    public function setSendTo($sendTo)
    {
        $this->sendTo = $sendTo;
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
     * @return mixed
     */
    public function getisDelivered()
    {
        return $this->isDelivered;
    }

    /**
     * @param mixed $isDelivered
     */
    public function setIsDelivered($isDelivered)
    {
        $this->isDelivered = $isDelivered;
    }
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'send_to'=>$this->getSendTo(),
            'campaign'=>$this->getCampaign()->getArray(),
            'message'=>$this->getMessage(),
            'is_delivered'=>$this->getisDelivered(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getArray(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getArray(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}