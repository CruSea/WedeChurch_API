<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 12:59 AM
 */

namespace NegaritSMS\Controllers;

use NegaritSMS\Entities\Campaign;
use NegaritSMS\Entities\SendMessage;
use NegaritSMS\Entities\User;
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
    const Unknown_Service_Request = "Unknown Service Request";
}
class RequestFormat extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const SERVICE = 'service';
    const PARAM = 'param';
}
abstract class AvailableServices extends BasicEnum {
    const AUTHENTICATE = 'authenticate';
    const ADD_NEW_SEND_MESSAGE = 'add_new_send_message';

    const REMOVE_SEND_MESSAGE = 'remove_send_message';

    const LOG_IN = "log_in";

    const GET_ALL_COMPANY_SMS_PORTS = "get_all_company_sms_ports";
    const GET_ACTIVE_COMPANY_SMS_PORTS = "get_active_company_sms_ports";
    const GET_ALL_COMPANY_CAMPAIGN = "get_all_company_campaigns";
    const GET_ALL_COMPANY_SEND_MESSAGES = "get_all_company_send_messages";
}
class FORMAT_AddSendMessage extends BasicEnum {
    const MESSAGE_TO = 'to';
    const MESSAGE_MESSAGE = 'message';
    const MESSAGE_CAMPAIGN_NAME = 'campaign_name';
}
class FORMAT_ByItemID extends BasicEnum {
    const ITEM_ID = 'item_id';
}
class APIProcessRequest
{
    /**
     * @var Service $ServiceManager;
     */
    protected $ServiceManager;
    protected $Request;
    protected $Message;

    /**
     * APIProcessRequest constructor.
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
    private function isValidRequestFormat(){
        return RequestFormat::isValidParam($this->Request);
    }
    private function getRequestedService(){
        return $this->Request[RequestFormat::SERVICE];
    }
    private function getRequestParam(){
        return json_decode($this->Request[RequestFormat::PARAM],true);
    }
    private function getMainUser(){
        $newUser = new User();
        $newUser->setUserPass($this->Request[RequestFormat::USER_PASS]);
        $newUser->setUserName($this->Request[RequestFormat::USER_NAME]);
        $newUser->setEmail($this->Request[RequestFormat::USER_NAME]);
        $foundUser = $this->ServiceManager->checkUser($newUser);
        if($foundUser){
            return $foundUser;
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Invalid_User_Account;
        }
    }
    private function getSuperAdmin(){
        $newUser = new User();
        $newUser->setId(1);
        $foundUser = $this->ServiceManager->getUser($newUser);
        if($foundUser){
            return $foundUser;
        }else{
            return null;
        }
    }

    private function ProcessRequest()
    {
        if (in_array($this->getRequestedService(), array_values(AvailableServices::getConstants()))) {
            /**
             * Check for Services
             */
            if ($this->getRequestedService() == AvailableServices::AUTHENTICATE) {
                /** Authenticate user */
                $found = $this->getMainUser();
                if ($found) {
                    $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed_Login;
                }
                return true;
            } elseif ($this->getRequestedService() == AvailableServices::LOG_IN) {
                /** Log in user */
                $found = $this->getMainUser();
                if ($found) {
                    $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed_Login;
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_SEND_MESSAGE) {
                /** Add new Send Message */
                $found = $this->getMainUser();
                if (FORMAT_AddSendMessage::isValidParam($this->getRequestParam())) {
                    if($found->getPrivilege()->getId() < 4){
                        $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($companyUser){
                            $newCampaign = new Campaign();
                            $newCampaign->setName($this->getRequestParam()[FORMAT_AddSendMessage::MESSAGE_CAMPAIGN_NAME]);
                            $foundCampaign = $this->ServiceManager->getCampaignByCompanyAndName($companyUser->getCompany(),$newCampaign);
                            if($foundCampaign){
                                $newSendMessage = new SendMessage();
                                $newSendMessage->setSendTo($this->getRequestParam()[FORMAT_AddSendMessage::MESSAGE_TO]);
                                $newSendMessage->setMessage($this->getRequestParam()[FORMAT_AddSendMessage::MESSAGE_MESSAGE]);
                                $newSendMessage->setCampaign($foundCampaign);
                                $newSendMessage->setIsDelivered(0);
                                $newSendMessage->setCreatedBy($found);
                                $newSendMessage->setUpdatedBy($found);
                                $SendMessage = $this->ServiceManager->addNewSendMessage($newSendMessage);
                                if($SendMessage){
                                    $this->Message[ResponsesType::RESPONSE] = $SendMessage->getArray();
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Failed to add new campain";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "SMS port Could not be found";
                            }
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                }
            }elseif ($this->getRequestedService() == AvailableServices::REMOVE_SEND_MESSAGE) {
                /** Remove SMS Port */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $newSendMessage = new SendMessage();
                        $newSendMessage->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                        if($this->ServiceManager->removeSendMessage($newSendMessage)){
                            $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to remove the sms port";
                        }
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_SMS_PORTS) {
                /** Get All company SMS PORTS */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $smsPorts = $this->ServiceManager->getAllSMSPortsByCompany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $smsPorts;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ACTIVE_COMPANY_SMS_PORTS) {
                /** Get All company SMS PORTS */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $smsPorts = $this->ServiceManager->getActiveSMSPortsByCompany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $smsPorts;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_CAMPAIGN) {
                /** Get All company Campains */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $companyCampaigns = $this->ServiceManager->getALLCampaignsByCompany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $companyCampaigns;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_SEND_MESSAGES) {
                /** Get All company Send Messages */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $companySendMessages = $this->ServiceManager->getALLSendMessageByCompany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $companySendMessages;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            }elseif ($this->getRequestedService() == AvailableServices::GET_ALL_PRIVILEGES) {
                /** get all privileges */
                $found = $this->getMainUser();
                if($found){
                    $privilages = $this->ServiceManager->getLessPrivilege($found->getPrivilege());
                    $this->Message[ResponsesType::RESPONSE] = $privilages;
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            }else{
                $this->Message[ResponsesType::ERROR] = Responses::Unknown_Service_Request;
            }
        }
    }
    public function Process(){
        if($this->isValidRequestFormat()){
            $this->ProcessRequest();
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Request_Format;
        }
    }


}