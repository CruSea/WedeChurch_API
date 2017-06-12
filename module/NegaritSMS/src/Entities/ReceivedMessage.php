<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 2:42 PM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="received_messages")
 */
class ReceivedMessage extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="SMSPort")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     * @var SMSPort $SMSPort
     */
    protected $SMSPort;
    /**
     * @ORM\Column(name="message_id", type="string", unique=false, nullable=false)
     */
    protected $messageID;
    /**
     * @ORM\Column(name="message_from", type="string", unique=false, nullable=false)
     */
    protected $messageFrom;
    /**
     * @ORM\Column(name="message", type="string", unique=false, nullable=false)
     */
    protected $message;
    /**
     * @ORM\Column(name="message_to", type="string", unique=false, nullable=false)
     */
    protected $messageTo;

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
    public function getSMSPort()
    {
        return $this->SMSPort;
    }

    /**
     * @param mixed $SMSPort
     */
    public function setSMSPort($SMSPort)
    {
        $this->SMSPort = $SMSPort;
    }

    /**
     * @return mixed
     */
    public function getMessageID()
    {
        return $this->messageID;
    }

    /**
     * @param mixed $messageID
     */
    public function setMessageID($messageID)
    {
        $this->messageID = $messageID;
    }

    /**
     * @return mixed
     */
    public function getMessageFrom()
    {
        return $this->messageFrom;
    }

    /**
     * @param mixed $messageFrom
     */
    public function setMessageFrom($messageFrom)
    {
        $this->messageFrom = $messageFrom;
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
    public function getMessageTo()
    {
        return $this->messageTo;
    }

    /**
     * @param mixed $messageTo
     */
    public function setMessageTo($messageTo)
    {
        $this->messageTo = $messageTo;
    }


}