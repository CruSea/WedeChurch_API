<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 3:44 PM
 */

namespace NegaritSMS\DataModels;


class Dashboard
{
    protected $SentMessages;
    protected $ReceivedMessages;
    protected $Campaigns;
    protected $CampaignsStatus;
    protected $Users;
    protected $History;
    protected $LastMessages;
    protected $Contacts;

    public function getArray(){
        return array(
            'sent_messages'=>$this->getSentMessages(),
            'received_messages'=>$this->getReceivedMessages(),
            'campaigns'=>$this->getCampaigns(),
            'campaigns_status'=>$this->getCampaignsStatus(),
            'users'=>$this->getUsers(),
            'history'=>$this->getHistory(),
            'last_sent_messages'=>$this->getLastMessages(),
            'contacts'=>$this->getContacts(),
        );
    }

    /**
     * @return mixed
     */
    public function getCampaignsStatus()
    {
        return $this->CampaignsStatus;
    }

    /**
     * @param mixed $CampaignsStatus
     */
    public function setCampaignsStatus($CampaignsStatus)
    {
        $this->CampaignsStatus = $CampaignsStatus;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->Contacts;
    }

    /**
     * @param mixed $Contacts
     */
    public function setContacts($Contacts)
    {
        $this->Contacts = $Contacts;
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
    public function getCampaigns()
    {
        return $this->Campaigns;
    }

    /**
     * @param mixed $Campaigns
     */
    public function setCampaigns($Campaigns)
    {
        $this->Campaigns = $Campaigns;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->Users;
    }

    /**
     * @param mixed $Users
     */
    public function setUsers($Users)
    {
        $this->Users = $Users;
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        return $this->History;
    }

    /**
     * @param mixed $History
     */
    public function setHistory($History)
    {
        $this->History = $History;
    }

    /**
     * @return mixed
     */
    public function getLastMessages()
    {
        return $this->LastMessages;
    }

    /**
     * @param mixed $LastMessages
     */
    public function setLastMessages($LastMessages)
    {
        $this->LastMessages = $LastMessages;
    }


}