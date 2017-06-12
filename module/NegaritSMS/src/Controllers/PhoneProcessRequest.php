<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 11:05 AM
 */

namespace NegaritSMS\Controllers;

use NegaritSMS\Entities\ReceivedMessage;
use NegaritSMS\Entities\SendMessage;
use NegaritSMS\Entities\SMSPort;
use NegaritSMS\Services\Service;

class Responses {
    const Invalid_Request_Format = 'Invalid Request Format';
    const USER_PASS = 'user_pass';
    const SERVICE = 'service';
    const PARAM = 'param';
    const Unknown_Service_Request = "Unknown Service Request";
    const Invalid_Param_For_Signup = "Invalid Param for Sign up";
    const Invalid_User_Account = "Invalid User Credential used!";
    const Registration_Failed = "Registration Failed";
    const Failed = "Failed";
    const Invalid_Param = "Invalid Parameter Used!";
    const UnAuthorized_User = "UnAuthorized User!";
    const Permission_Denied = "Permission Denied";
    const Failed_Login = "Failed to log in";
}
class ResponsesType {
    const ERROR = 'error';
    const RESPONSE = 'response';
    const SERVICE = 'service';
    const PARAM = 'param';
    const PAYLOAD = "payload";
    const Unknown_Service_Request = "Unknown Service Request";
}
abstract class AvailableServices extends BasicEnum
{
    const AUTHENTICATE = 'authenticate';
    const REGISTER = 'register';
    const ADD_USER = 'add_user';
    const ADD_NEW_SMS_PORT = 'add_new_sms_port';
    const ADD_NEW_CAMAPAIGN = 'add_new_campaign';
    const ADD_NEW_SEND_MESSAGE = 'add_new_send_message';
}
abstract class deviceTable {
    const ID = 'ID';
    const DEVICE_NAME = 'deviceName';
    const DEVICE_DESCRIPTION = 'deviceDescription';
    const DEVICE_PASS = 'devicePass';
    const DEVICE_PHONE = 'devicePhone';
    const UPDATED_DATE = 'updatedDate';
}
class PhoneProcessRequest
{
    /**
     * @var Service $ServiceManager;
     */
    protected $ServiceManager;
    protected $Request;
    protected $Message;

    /**
     * PhoneProcessRequest constructor.
     * @param Service $ServiceManager
     * @param $Request
     */
    public function __construct(Service $ServiceManager, $Request)
    {
        $this->ServiceManager = $ServiceManager;
        $this->Request = $Request;
    }

    /**
     * @return Service
     */
    public function getServiceManager()
    {
        return $this->ServiceManager;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->Request;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->Message;
    }

    public function ProcessPOSTRequest()
    {
        $newSMSPort = new SMSPort();
        $newSMSPort->setDeviceID($this->getRequest()['device_id']);
        $newSMSPort->setSecret($this->getRequest()['secret']);
        $smsPort = $this->ServiceManager->getSMSPortByDeviceIDAndSecret($newSMSPort);
        if($this->getRequest()['request_type'] == "get_messages" && $smsPort){
            if($smsPort){
                $campaigns = $this->ServiceManager->listCampaignsBySMSPort($smsPort);
                $send_messages = $this->ServiceManager->getNotDeliveredSendMessagesByCampaignIDs($campaigns);
                if(count($send_messages)>0){
                    $messages = array();
                    foreach ($send_messages as $send_message){
                        $newSendMessage = new SendMessage();
                        $newSendMessage->setId($send_message['id']);

                        /**
                         * @var SendMessage $foundSendMessage
                         */
                        $foundSendMessage = $this->ServiceManager->getSendMessage($newSendMessage);
                        if($foundSendMessage){
                            $foundSendMessage->setIsDelivered(1);
                            $this->ServiceManager->updateSendMessage($foundSendMessage);
                        }
                        $sms = array();
                        $sms['to'] = $send_message['send_to'];
                        $sms['message'] = $send_message['message'];
                        $sms['uuid'] = "232ehwkkhsfsw3242334234".$send_message['id'];
                        $messages[] = $sms;
                    }
                    $payload = array();
                    $payload['device_id'] = $smsPort->getDeviceID();
                    $payload['secret'] = $smsPort->getSecret();
                    $payload['messages'] = $messages;
                    $this->Message[ResponsesType::RESPONSE] = $payload;
                }else{
                    $payload = array();
                    $payload['success'] = false;
                    $payload['error'] = "There is no message to be send";
                    $this->Message[ResponsesType::RESPONSE] = $payload;
                }
            }else{
                $payload = array();
                $payload['success'] = false;
                $payload['error'] = "SMS port cannot be found";
                $this->Message[ResponsesType::RESPONSE] = $payload;
            }
        }elseif ($this->getRequest()['request_type'] == "send_messages"){
            $payload = array();
            $payload['success'] = false;
            $payload['error'] = "Send SMS";
            $this->Message[ResponsesType::RESPONSE] = $payload;
        }else{
            $payload = array();
            $payload['success'] = false;
            $payload['error'] = "Request Type not known";
            $this->Message[ResponsesType::RESPONSE] = $payload;
        }
    }
    public function ProcessGETRequest()
    {

    }


}