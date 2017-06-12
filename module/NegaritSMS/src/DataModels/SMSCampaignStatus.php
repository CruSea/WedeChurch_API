<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 5:27 PM
 */

namespace NegaritSMS\DataModels;


class SMSCampaignStatus
{
    protected $Name;
    protected $SentMessages;
    protected $ReceivedMessages;
    protected $CreatedBy;
    protected $LastSentBy;
    protected $CreatedDate;

    public function getArray(){
        return array(
            'campaign_name'=>$this->getName(),
            'sent_messages'=>$this->getSentMessages(),
            'received_messages'=>$this->getReceivedMessages(),
            'created_by'=>$this->getCreatedBy(),
            'created_date'=>$this->getCreatedDate(),
        );
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getSentMessages()
    {
        return $this->SentMessages;
    }

    /**
     * @param mixed $SentMessages
     */
    public function setSentMessages($SentMessages)
    {
        $this->SentMessages = $SentMessages;
    }

    /**
     * @return mixed
     */
    public function getReceivedMessages()
    {
        return $this->ReceivedMessages;
    }

    /**
     * @param mixed $ReceivedMessages
     */
    public function setReceivedMessages($ReceivedMessages)
    {
        $this->ReceivedMessages = $ReceivedMessages;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->CreatedBy;
    }

    /**
     * @param mixed $CreatedBy
     */
    public function setCreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;
    }

    /**
     * @return mixed
     */
    public function getLastSentBy()
    {
        return $this->LastSentBy;
    }

    /**
     * @param mixed $LastSentBy
     */
    public function setLastSentBy($LastSentBy)
    {
        $this->LastSentBy = $LastSentBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->CreatedDate;
    }

    /**
     * @param mixed $CreatedDate
     */
    public function setCreatedDate($CreatedDate)
    {
        $this->CreatedDate = $CreatedDate;
    }

}