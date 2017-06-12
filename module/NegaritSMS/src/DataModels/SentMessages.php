<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 4:55 PM
 */

namespace NegaritSMS\DataModels;


class SentMessages
{
    protected $CampaignName;
    protected $Message;
    protected $DateTime;
    protected $CreatedBy;

    public function getArray(){
        return array(
            'campaign_name'=>$this->getCampaignName(),
            'message'=>$this->getMessage(),
            'date_time'=>$this->getDateTime(),
            'created_by'=>$this->getCreatedBy(),
        );
    }

    /**
     * @return mixed
     */
    public function getCampaignName()
    {
        return $this->CampaignName;
    }

    /**
     * @param mixed $CampaignName
     */
    public function setCampaignName($CampaignName)
    {
        $this->CampaignName = $CampaignName;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * @param mixed $Message
     */
    public function setMessage($Message)
    {
        $this->Message = $Message;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->DateTime;
    }

    /**
     * @param mixed $DateTime
     */
    public function setDateTime($DateTime)
    {
        $this->DateTime = $DateTime;
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


}