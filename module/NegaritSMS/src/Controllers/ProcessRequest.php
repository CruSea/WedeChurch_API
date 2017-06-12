<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 1:43 PM
 */

namespace NegaritSMS\Controllers;

use NegaritSMS\Entities\Campaign;
use NegaritSMS\Entities\CampaignUser;
use NegaritSMS\Entities\Company;
use NegaritSMS\Entities\CompanyUser;
use NegaritSMS\Entities\Contact;
use NegaritSMS\Entities\ForgotPassword;
use NegaritSMS\Entities\Group;
use NegaritSMS\Entities\GroupedContact;
use NegaritSMS\Entities\GroupMessage;
use NegaritSMS\Entities\Privilege;
use NegaritSMS\Entities\SendMessage;
use NegaritSMS\Entities\SMSPort;
use NegaritSMS\Entities\User;
use NegaritSMS\Services\Service;
use PhoneBook\Controllers\FORMAT_ItemID;

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
    const Company_User_Not_Found = "Company User Not Found";
    const Company_Account_Not_ACTIVE = "Your company account is not active! please contact us";
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
    const REGISTER = 'register';
    const FORGOT_PASSWORD = 'forgot_password';
    const RESET_PASSWORD = 'reset_password';

    const ADD_USER = 'add_user';
    const ADD_NEW_SMS_PORT = 'add_new_sms_port';
    const ADD_NEW_CAMAPAIGN = 'add_new_campaign';
    const ADD_NEW_SEND_MESSAGE = 'add_new_send_message';
    const ADD_NEW_COMPANY_CONTACT = 'add_new_company_contact';
    const ADD_NEW_COMPANY_GROUP = 'add_new_company_group';
    const ADD_NEW_COMPANY_GROUP_CONTACT = 'add_new_company_group_contact';
    const ADD_COMPANY_GROUP_CONTACT = 'add_company_group_contact';
    const ADD_COMPANY_GROUP_MESSAGE = 'add_company_group_message';
    const ADD_COMPANY_CAMPAIGN_USER = 'add_company_campaign_user';

    const REMOVE_USER = 'remove_user';
    const REMOVE_COMPANY_SMS_PORT = 'remove_company_sms_port';
    const REMOVE_COMPANY_CAMPAIGN = 'remove_company_campaign';
    const REMOVE_COMPANY_SEND_MESSAGE = 'remove_company_send_message';
    const REMOVE_COMPANY_CONTACT = 'remove_company_contact';
    const REMOVE_COMPANY_GROUP = 'remove_company_group';
    const REMOVE_COMPANY_GROUP_CONTACT = 'remove_company_group_contact';
    const REMOVE_COMPANY_GROUPED_CONTACT = 'remove_company_grouped_contact';
    const REMOVE_COMPANY_GROUP_MESSAGE = 'remove_company_group_message';

    const LOG_IN = "log_in";
    const GET_DASHBOARD = "get_dashboard";
    const GET_COMPANY_USERS = "get_company_users";
    const GET_ALL_SMS_PORTS = "get_all_sms_ports";
    const GET_ALL_COMPANY_SMS_PORTS = "get_all_company_sms_ports";
    const GET_ACTIVE_COMPANY_SMS_PORTS = "get_active_company_sms_ports";
    const GET_ALL_CAMPAIGN = "get_all_campaigns";
    const GET_ALL_COMPANIES = "get_all_companies";
    const GET_ALL_ACTIVE_COMPANIES = "get_all_active_companies";
    const GET_ALL_NOT_ACTIVE_COMPANIES = "get_all_not_active_companies";
    const GET_ALL_COMPANY_CAMPAIGN = "get_all_company_campaigns";
    const GET_ALL_COMPANY_SEND_MESSAGES = "get_all_company_send_messages";
    const GET_ALL_COMPANY_CONTACTS = "get_all_company_contacts";
    const GET_ALL_COMPANY_GROUPS= "get_all_company_groups";
    const GET_ALL_COMPANY_GROUP_CONTACTS= "get_all_company_group_contacts";
    const GET_ALL_COMPANY_GROUP_MESSAGES= "get_all_company_group_messages";
    const GET_ALL_COMPANY_SENT_MESSAGES= "get_all_company_sent_messages";
    const GET_ALL_COMPANY_GROUP_CONTACTS_NOT_IN_GROUP = "get_all_company_group_contacts_not_in_group";
    const GET_ALL_COMPANY_GROUP_CONTACTS_IN_GROUP = "get_all_company_group_contacts_in_group";
    const GET_ALL_COMPANY_GROUPED_CONTACTS_IN_GROUP = "get_all_company_grouped_contacts_in_group";
    const GET_PRIVILEGES = "get_privileges";

    const ACTIVATE_COMPANY_ACCOUNT = 'activate_company_account';
    const DEACTIVATE_COMPANY_ACCOUNT = 'deactivate_company_account';
}
class FORMAT_REGISTER extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const USER_EMAIL = 'email';
    const FULL_NAME = 'full_name';
    const COMPANY_NAME = 'company_name';
}
class FORMAT_FORGOT_PASSWORD extends BasicEnum {
    const USER_EMAIL = 'email';
}
class FORMAT_RESET_PASSWORD extends BasicEnum {
    const USER_EMAIL = 'email';
    const RESET_CODE = 'reset_code';
    const NEW_PASSWORD = 'password';
}
class FORMAT_AddUser extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const FULL_NAME = 'full_name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const PRIVILEGE = 'privilege';
}
class FORMAT_AddSMSPort extends BasicEnum {
    const PORT_NAME = 'port_name';
    const PORT_PHONE = 'port_phone';
    const PORT_DESCRIPTION = 'description';
}
class FORMAT_CONTACT extends BasicEnum {
    const CONTACT_FULL_NAME = 'full_name';
    const CONTACT_PHONE = 'phone';
    const CONTACT_EMAIL = 'email';
    const CONTACT_LOCATION = 'location';
    const CONTACT_NOTE = 'note';
    const CONTACT_DESCRIPTION = 'description';
}
class FORMAT_GROUP extends BasicEnum {
    const GROUP_NAME = 'name';
    const GROUP_DESCRIPTION = 'description';
}
class FORMAT_GROUP_CONTACT extends BasicEnum {
    const GROUP_ID = 'group_id';
    const CONTACT_ID = 'contact_id';
}
class FORMAT_GROUP_MESSAGE extends BasicEnum {
    const GROUP_ID = 'group_id';
    const CAMPAIGN_ID = 'campaign_id';
    const MESSAGE = 'message';
}
class FORMAT_CAMPAIGN_USER extends BasicEnum {
    const CAMPAIGN_ID = 'campaign_id';
    const USER_ID = 'user_id';
}
class FORMAT_AddSendMessage extends BasicEnum {
    const MESSAGE_TO = 'to';
    const MESSAGE_MESSAGE = 'message';
    const MESSAGE_CAMPAIGN_NAME = 'campaign_name';
}
class FORMAT_AddCampaign extends BasicEnum {
    const CAMPAIGN_NAME = 'campaign_name';
    const CAMPAIGN_PORT_NAME = 'campaign_port_name';
    const CAMPAIGN_DESCRIPTION = 'campaign_description';
}
class FORMAT_ByItemID extends BasicEnum {
    const ITEM_ID = 'item_id';
}
class ProcessRequest
{
    /**
     * @var Service $ServiceManager;
     */
    protected $ServiceManager;
    protected $Request;
    protected $Message;

    /**
     * ProcessRequest constructor.
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
            if($foundUser && $foundUser->getPrivilege()->getId() == 1){
                return $foundUser;
            }elseif ($foundUser->getisActive()){
                /**
                 * @var CompanyUser $companyUser
                 */
                $companyUser = $this->ServiceManager->getCompanyUserByUser($foundUser);
                if($companyUser->getCompany()->getisActive()){
                    return $foundUser;
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Company_Account_Not_ACTIVE;
                }
            }else{
                $this->Message[ResponsesType::ERROR] = Responses::Invalid_User_Account;
            }
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

    /**
     * @return bool
     */
    private function ProcessRequest()
    {
        if (in_array($this->getRequestedService(), array_values(AvailableServices::getConstants()))) {
            /**
             * Check for Services
             */
            if ($this->getRequestedService() == AvailableServices::AUTHENTICATE) {
                /** Authenticate user */
                return true;
            } elseif ($this->getRequestedService() == AvailableServices::LOG_IN) {
                /** Log in user */
                $found = $this->getMainUser();
                if ($found) {
                    $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                }
            }elseif ($this->getRequestedService() == AvailableServices::FORGOT_PASSWORD) {
                /** Forgot password */
                if (FORMAT_FORGOT_PASSWORD::isValidParam($this->getRequestParam())) {
                    $superAdmin = $this->getSuperAdmin();
                    $oldUser = new User();
                    $oldUser->setEmail($this->getRequestParam()[FORMAT_FORGOT_PASSWORD::USER_EMAIL]);
                    $foundOldUser = $this->ServiceManager->getUserByEmail($oldUser);
                    if($foundOldUser){
                        $this->ServiceManager->removeForgotPasswordsByUser($foundOldUser);
                        $newForgotPassword = new ForgotPassword();
                        $newForgotPassword->setUser($foundOldUser);
                        $newForgotPassword->setResetCode($this->getRandomString());
                        $newForgotPassword->setCreatedBy($superAdmin);
                        $newForgotPassword->setUpdatedBy($superAdmin);
                        if($this->ServiceManager->addForgotPassword($newForgotPassword)){
                            $this->Message[ResponsesType::RESPONSE] = "Reset code has been sent to your email";
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Something wrong please try again";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = "There is no associated account with this email";
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = "Something wrong please try again";
                }
            }elseif ($this->getRequestedService() == AvailableServices::RESET_PASSWORD) {
                /** Reset password */
                if (FORMAT_RESET_PASSWORD::isValidParam($this->getRequestParam())) {
                    $superAdmin = $this->getSuperAdmin();
                    $oldUser = new User();
                    $oldUser->setEmail($this->getRequestParam()[FORMAT_RESET_PASSWORD::USER_EMAIL]);
                    $foundOldUser = $this->ServiceManager->getUserByEmail($oldUser);
                    if($foundOldUser){
                        $newForgotPassword = new ForgotPassword();
                        $newForgotPassword->setUser($foundOldUser);
                        $newForgotPassword->setResetCode($this->getRequestParam()[FORMAT_RESET_PASSWORD::RESET_CODE]);
                        $foundOldForgotPassword = $this->ServiceManager->getForgotPasswordByResetCodeAndUserEmail($newForgotPassword);
                        if($foundOldForgotPassword){
                            $foundOldUser->setUserPass(sha1($this->getRequestParam()[FORMAT_RESET_PASSWORD::NEW_PASSWORD]));
                            if($this->ServiceManager->updateUser($foundOldUser)){
                                $this->ServiceManager->removeForgotPassword($foundOldForgotPassword);
                                $this->Message[ResponsesType::RESPONSE] = "Your Password Reseted";
                            }else{
                                $this->Message[ResponsesType::ERROR] = " Error 1: Failed to reset your password! please try gain";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = " Error 2: Failed to reset your password! please try gain";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = " Error 3: Failed to reset your password! please try gain";
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = "Error 4: Failed to reset your password! please try gain";
                }
            }elseif ($this->getRequestedService() == AvailableServices::REGISTER) {
                /** Sign up new user */
                if (FORMAT_REGISTER::isValidParam($this->getRequestParam())) {
                    $superAdmin = $this->getSuperAdmin();
                    if($superAdmin){
                        $newUser = new User();
                        $newUser->setUserPass($this->getRequestParam()[FORMAT_REGISTER::USER_PASS]);
                        $newUser->setUserName($this->getRequestParam()[FORMAT_REGISTER::USER_NAME]);
                        $newUser->setFullName($this->getRequestParam()[FORMAT_REGISTER::FULL_NAME]);
                        $newUser->setEmail($this->getRequestParam()[FORMAT_REGISTER::USER_EMAIL]);
                        $newUser->setUpdatedBy($superAdmin);
                        $newUser->setCreatedBy($superAdmin);
                        $newPriv = new Privilege();
                        $newPriv->setId(2);
                        // Get Privilege
                        $privilege = $this->ServiceManager->getPrivilege($newPriv);
                        if($privilege){
                            $newUser->setPrivilege($privilege);
                            $addedUser = $this->ServiceManager->addUser($newUser);
                            if ($addedUser) {
                                $newCompany = new Company();
                                $newCompany->setName($this->getRequestParam()[FORMAT_REGISTER::COMPANY_NAME]);
                                $newCompany->setCreatedBy($addedUser);
                                $newCompany->setUpdatedBy($addedUser);
                                $addedCompany = $this->ServiceManager->addCompany($newCompany);
                                if ($addedCompany) {
                                    $newCompanyUser = new CompanyUser();
                                    $newCompanyUser->setCompany($addedCompany);
                                    $newCompanyUser->setUser($addedUser);
                                    $newCompanyUser->setCreatedBy($addedUser);
                                    $newCompanyUser->setUpdatedBy($addedUser);
                                    $addedCompanyUser = $this->ServiceManager->addCompanyUser($newCompanyUser);
                                    if ($addedCompanyUser) {
                                        $this->Message[ResponsesType::RESPONSE] = $addedUser->getArray();
                                    } else {
                                        $this->Message[ResponsesType::ERROR] = "Failed to bind the user with the company";
                                    }
                                } else {
                                    $this->Message[ResponsesType::ERROR] = "Failed to register the Company";
                                }
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to Register the user";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Privilege not Found";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = "The Super Admin could not be found now! please try again!!!";
                    }
                } else {
                    $this->Message[ResponsesType::ERROR] = "Invalid Registration Param used!";
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_USER) {
                /** Add new user */
                $found = $this->getMainUser();
                if ($found) {
                    if (FORMAT_AddUser::isValidParam($this->getRequestParam())) {
                        if($found->getPrivilege()->getId() < 4){
                            $newUser = new User();
                            $newUser->setUserPass($this->getRequestParam()[FORMAT_AddUser::USER_PASS]);
                            $newUser->setUserName($this->getRequestParam()[FORMAT_AddUser::USER_NAME]);
                            $newUser->setFullName($this->getRequestParam()[FORMAT_AddUser::FULL_NAME]);
                            $newUser->setEmail($this->getRequestParam()[FORMAT_AddUser::EMAIL]);
                            $newUser->setPhone($this->getRequestParam()[FORMAT_AddUser::PHONE]);
                            $newUser->setCreatedBy($found);
                            $newUser->setUpdatedBy($found);
                            $newPriv = new Privilege();
                            $newPriv->setId($this->getRequestParam()[FORMAT_AddUser::PRIVILEGE]);
                            $privilege = $this->ServiceManager->getPrivilege($newPriv);
                            if($privilege){
                                $newUser->setPrivilege($privilege);
                                $addedUser = $this->ServiceManager->addUser($newUser);
                                if ($addedUser) {
                                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                                    $newCompanyUser = new CompanyUser();
                                    $newCompanyUser->setCompany($companyUser->getCompany());
                                    $newCompanyUser->setUser($addedUser);
                                    $state = $this->ServiceManager->addCompanyUser($newCompanyUser);
                                    if ($state) {
                                        $this->Message[ResponsesType::RESPONSE] = $addedUser->getArray();
                                    } else {
                                        $this->ServiceManager->removeUser($addedUser);
                                        $this->Message[ResponsesType::ERROR] = Responses::Registration_Failed;
                                    }
                                } else {
                                    $this->Message[ResponsesType::ERROR] = Responses::Registration_Failed;
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Privilege not found";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_SMS_PORT) {
                /** Add new SMS Port */
                $found = $this->getMainUser();
                if ($found) {
                    if (FORMAT_AddSMSPort::isValidParam($this->getRequestParam())) {
                        if($found->getPrivilege()->getId() < 4){
                            $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                            if($companyUser){
                                $newSMSPort = new SMSPort();
                                $newSMSPort->setName($this->getRequestParam()[FORMAT_AddSMSPort::PORT_NAME]);
                                $newSMSPort->setCompany($companyUser->getCompany());
                                $newSMSPort->setPhone($this->getRequestParam()[FORMAT_AddSMSPort::PORT_PHONE]);
                                $newSMSPort->setDescription($this->getRequestParam()[FORMAT_AddSMSPort::PORT_DESCRIPTION]);
                                $newSMSPort->setSecret("");
                                $newSMSPort->setDeviceID("");
                                $newSMSPort->setCreatedBy($found);
                                $newSMSPort->setUpdatedBy($found);
                                $SMSPort = $this->ServiceManager->addSMSPort($newSMSPort);
                                if($SMSPort){
                                    $this->Message[ResponsesType::RESPONSE] = $SMSPort->getArray();
                                }else{
                                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                                }
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_CAMAPAIGN) {
                /** Add new SMS Port */
                $found = $this->getMainUser();
                if ($found) {
                    if (FORMAT_AddCampaign::isValidParam($this->getRequestParam())) {
                        if($found->getPrivilege()->getId() < 4){
                            $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                            if($companyUser){
                                $newSMSPort = new SMSPort();
                                $newSMSPort->setName($this->getRequestParam()[FORMAT_AddCampaign::CAMPAIGN_PORT_NAME]);
                                $SMSPort = $this->ServiceManager->getSMSPortByCompanyAndName($companyUser->getCompany(),$newSMSPort);
                                if($SMSPort){
                                    $newCampaign = new Campaign();
                                    $newCampaign->setName($this->getRequestParam()[FORMAT_AddCampaign::CAMPAIGN_NAME]);
                                    $newCampaign->setCompany($companyUser->getCompany());
                                    $newCampaign->setSMSPort($SMSPort);
                                    $newCampaign->setDescription($this->getRequestParam()[FORMAT_AddCampaign::CAMPAIGN_DESCRIPTION]);
                                    $newCampaign->setCreatedBy($found);
                                    $newCampaign->setUpdatedBy($found);
                                    $Campain = $this->ServiceManager->addNewCampaign($newCampaign);
                                    if($Campain){
                                        $this->Message[ResponsesType::RESPONSE] = $SMSPort->getArray();
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
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_COMPANY_CONTACT) {
                /** Add new Company Contact */
                $found = $this->getMainUser();
                if ($found) {
                    $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($foundCompanyUser){
                        if (FORMAT_CONTACT::isValidParam($this->getRequestParam())) {
                            $newContact = new Contact();
                            $newContact->setFullName($this->getRequestParam()[FORMAT_CONTACT::CONTACT_FULL_NAME]);
                            $newContact->setPhoneNumber($this->getRequestParam()[FORMAT_CONTACT::CONTACT_PHONE]);
                            $newContact->setEmail($this->getRequestParam()[FORMAT_CONTACT::CONTACT_EMAIL]);
                            $newContact->setLocation($this->getRequestParam()[FORMAT_CONTACT::CONTACT_LOCATION]);
                            $newContact->setNote($this->getRequestParam()[FORMAT_CONTACT::CONTACT_NOTE]);
                            $newContact->setDescription($this->getRequestParam()[FORMAT_CONTACT::CONTACT_DESCRIPTION]);
                            $newContact->setCreatedBy($found);
                            $newContact->setCompany($foundCompanyUser->getCompany());
                            $newContact->setUpdatedBy($found);
                            $foundContact = $this->ServiceManager->addContact($newContact);
                            if($foundContact){
                                $this->Message[ResponsesType::RESPONSE] = $foundContact->getArray();
                            }else{
                                $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_COMPANY_GROUP) {
                /** Add new Company Contact */
                $found = $this->getMainUser();
                if ($found) {
                    $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($foundCompanyUser){
                        if (FORMAT_GROUP::isValidParam($this->getRequestParam())) {
                            $newGroup = new Group();
                            $newGroup->setName($this->getRequestParam()[FORMAT_GROUP::GROUP_NAME]);
                            $newGroup->setDescription($this->getRequestParam()[FORMAT_GROUP::GROUP_DESCRIPTION]);
                            $newGroup->setCompany($foundCompanyUser->getCompany());
                            $newGroup->setCreatedBy($found);
                            $newGroup->setUpdatedBy($found);
                            $foundGroup = $this->ServiceManager->addGroup($newGroup);
                            if($foundGroup){
                                $this->Message[ResponsesType::RESPONSE] = $foundGroup->getArray();
                            }else{
                                $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_COMPANY_GROUP_CONTACT) {
                /** Add Company Group Contact */
                $found = $this->getMainUser();
                if ($found) {
                    $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($foundCompanyUser){
                        if (FORMAT_GROUP_CONTACT::isValidParam($this->getRequestParam())) {
                            $newContact = new Contact();
                            $newContact->setId($this->getRequestParam()[FORMAT_GROUP_CONTACT::CONTACT_ID]);
                            $foundContact = $this->ServiceManager->getContact($newContact);

                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_GROUP_CONTACT::GROUP_ID]);
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);

                            if($foundContact && $foundGroup){
                                $newGroupedContact = new GroupedContact();
                                $newGroupedContact->setContact($foundContact);
                                $newGroupedContact->setGroup($foundGroup);
                                $newGroupedContact->setCreatedBy($found);
                                $newGroupedContact->setUpdatedBy($found);
                                $foundGroupedContact = $this->ServiceManager->addGroupedContact($newGroupedContact);
                                if($foundGroupedContact){
                                    $this->Message[ResponsesType::RESPONSE] = $foundGroupedContact->getArray();
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Error in adding contact group";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "could not found contact and group";
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_COMPANY_GROUP_MESSAGE) {
                /** Add Company Group Contact */
                $found = $this->getMainUser();
                if ($found) {
                    $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($foundCompanyUser){
                        if (FORMAT_GROUP_MESSAGE::isValidParam($this->getRequestParam())) {
                            $newCampaign = new Campaign();
                            $newCampaign->setId($this->getRequestParam()[FORMAT_GROUP_MESSAGE::CAMPAIGN_ID]);
                            /**
                             * @var Campaign $foundCampaign
                             */
                            $foundCampaign = $this->ServiceManager->getCampaign($newCampaign);

                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_GROUP_MESSAGE::GROUP_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);


                            if($foundCampaign && $foundGroup && $foundCampaign->getCompany()->getId() == $foundCompanyUser->getCompany()->getId() && $foundGroup->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                $newGroupMessage = new GroupMessage();
                                $newGroupMessage->setMessage($this->getRequestParam()[FORMAT_GROUP_MESSAGE::MESSAGE]);
                                $newGroupMessage->setCampaign($foundCampaign);
                                $newGroupMessage->setGroup($foundGroup);
                                $newGroupMessage->setCreatedBy($found);
                                $newGroupMessage->setUpdatedBy($found);
                                $foundGroupedMessage = $this->ServiceManager->addGroupMessage($newGroupMessage);
                                if($foundGroupedMessage){
                                    $contacts = $this->ServiceManager->listGroupedContactsByGroup($foundGroup);
                                    if($contacts){
                                        foreach ($contacts as $contact){
                                            /**
                                             * @var GroupedContact $contact
                                             */
                                            $newSendMessage = new SendMessage();
                                            $newSendMessage->setMessage($this->getRequestParam()[FORMAT_GROUP_MESSAGE::MESSAGE]);
                                            $newSendMessage->setCampaign($foundCampaign);
                                            $newSendMessage->setSendTo($contact->getContact()->getPhoneNumber());
                                            $newSendMessage->setIsDelivered(0);
                                            $newSendMessage->setCreatedBy($found);
                                            $newSendMessage->setUpdatedBy($found);
                                            $this->ServiceManager->addNewSendMessage($newSendMessage);
                                        }
                                    }
                                    $this->Message[ResponsesType::RESPONSE] = $foundGroupedMessage->getArray();
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Error in adding contact group";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            }elseif ($this->getRequestedService() == AvailableServices::ADD_COMPANY_CAMPAIGN_USER) {
                /** Add Company Group Contact */
                $found = $this->getMainUser();
                if ($found) {
                    $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($foundCompanyUser){
                        if (FORMAT_CAMPAIGN_USER::isValidParam($this->getRequestParam())) {
                            $newCampaign = new Campaign();
                            $newCampaign->setId($this->getRequestParam()[FORMAT_CAMPAIGN_USER::CAMPAIGN_ID]);
                            /**
                             * @var Campaign $foundCampaign
                             */
                            $foundCampaign = $this->ServiceManager->getCampaign($newCampaign);

                            $newUser = new User();
                            $newUser->setId($this->getRequestParam()[FORMAT_CAMPAIGN_USER::USER_ID]);
                            /**
                             * @var User $foundUser
                             */
                            $foundUser = $this->ServiceManager->getUser($newUser);

                            if($foundCampaign && $foundUser && $foundCampaign->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                $newCampaignUser = new CampaignUser();
                                $newCampaignUser->setCampaign($foundCampaign);
                                $newCampaignUser->setUser($foundUser);
                                $newCampaignUser->setCreatedBy($found);
                                $newCampaignUser->setUpdatedBy($found);
                                $foundCampaignUser = $this->ServiceManager->addCampaignUser($newCampaignUser);
                                if($foundCampaignUser){
                                    $this->Message[ResponsesType::RESPONSE] = $foundCampaignUser->getArray();
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Error in adding contact group";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "could not found contact and group";
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_USER) {
                /** Log in user */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getId() != $this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]){
                        $newUser = new User();
                        $newUser->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                        if($found->getPrivilege()->getId() < 4 && $found->getId() != $newUser->getId()){
                            $foundUser = $this->ServiceManager->getUser($newUser);
                            /**
                             * @var User $foundUser
                             */
                            if($foundUser && $foundUser->getPrivilege()->getId() > 2){
                                if($this->ServiceManager->getCompanyUserByUser($newUser)){
                                    if($this->ServiceManager->removeCompanyUserByUser($newUser)){
                                        if($this->ServiceManager->removeUser($newUser)){
                                            $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                                        }
                                    }else{
                                        $this->Message[ResponsesType::ERROR] = "Unable to remove the user";
                                    }
                                }else{
                                    if($this->ServiceManager->removeUser($newUser)){
                                        $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                                    }else{
                                        $this->Message[ResponsesType::ERROR] = "Unable to remove the user";
                                    }
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to remove Owner User";
                            }

                        }else{
                            $this->Message[ResponsesType::ERROR] = "this is not possible";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = "You cannot remove your current account!!";
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_SMS_PORT) {
                /** Remove SMS Port */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newSMSPort = new SMSPort();
                            $newSMSPort->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var SMSPort $foundSMSPort
                             */
                            $foundSMSPort = $this->ServiceManager->getSMSPort($newSMSPort);
                            if($foundSMSPort && $foundSMSPort->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()) {
                                if($this->ServiceManager->removeSMSPorts($foundSMSPort)){
                                    $this->Message[ResponsesType::RESPONSE] = "SMS Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the sms port";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the sms port in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_CAMPAIGN) {
                /** Remove SMS Port */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 3){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newCampaign = new Campaign();
                            $newCampaign->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Campaign $foundCampaign
                             */
                            $foundCampaign = $this->ServiceManager->getCampaign($newCampaign);
                            if($foundCampaign && $foundCampaign->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                $this->ServiceManager->removeCampaignUserByCampaign($foundCampaign);
                                if($this->ServiceManager->removeCampaign($foundCampaign)){
                                    $this->Message[ResponsesType::RESPONSE] = "Campaign Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the sms port";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the Campaign in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_SEND_MESSAGE) {
                /** Remove SMS Port */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newSendMessage = new SendMessage();
                            $newSendMessage->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var SendMessage $foundSendMessage
                             */
                            $foundSendMessage = $this->ServiceManager->getSendMessage($newSendMessage);
                            if($foundSendMessage && $foundSendMessage->getCampaign()->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                if($this->ServiceManager->removeSendMessage($foundSendMessage)){
                                    $this->Message[ResponsesType::RESPONSE] = "Message Removed!!";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the sent message";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to the sent message in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_CONTACT) {
                /** Remove SMS Port */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newContact = new Contact();
                            $newContact->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Contact $foundContact
                             */
                            $foundContact = $this->ServiceManager->getContact($newContact);
                            if($foundContact && $foundContact->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                if($this->ServiceManager->removeContact($foundContact)){
                                    $this->Message[ResponsesType::RESPONSE] = "Contact Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the contact";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the contact in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_GROUP) {
                /** Remove Company Group */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);
                            if($foundGroup && $foundGroup->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                $this->ServiceManager->removeGroupedContactByGroup($foundGroup);
                                if($this->ServiceManager->removeGroup($foundGroup)){
                                    $this->Message[ResponsesType::RESPONSE] = "Group Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the contact";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the contact in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_GROUP_CONTACT) {
                /** Remove Company Group Contact */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newContact = new Contact();
                            $newContact->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Contact $foundContact
                             */
                            $foundContact = $this->ServiceManager->getContact($newContact);
                            if($foundContact && $foundContact->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                if($this->ServiceManager->removeContact($foundContact)){
                                    $this->Message[ResponsesType::RESPONSE] = "Contact Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the contact";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the contact in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_GROUPED_CONTACT) {
                /** Remove Company Group Contact */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newGroupedContact = new GroupedContact();
                            $newGroupedContact->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var GroupedContact $foundGroupedContact
                             */
                            $foundGroupedContact = $this->ServiceManager->getGroupedContact($newGroupedContact);
                            if($foundGroupedContact && $foundGroupedContact->getGroup()->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                if($this->ServiceManager->removeGroupedContact($foundGroupedContact)){
                                    $this->Message[ResponsesType::RESPONSE] = "Grouped Contact Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the Groupedcontact";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the contact in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_COMPANY_GROUP_MESSAGE) {
                /** Remove Company Group Message */
                if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() < 4){
                        $foundCompanyUser = $this->ServiceManager->getCompanyUserByUser($found);
                        if($foundCompanyUser){
                            $newGroupMessage = new GroupMessage();
                            $newGroupMessage->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var GroupMessage $foundGroupMessages
                             */
                            $foundGroupMessages= $this->ServiceManager->getGroupMessage($newGroupMessage);
                            if($foundGroupMessages && $foundGroupMessages->getGroup()->getCompany()->getId() == $foundCompanyUser->getCompany()->getId()){
                                if($this->ServiceManager->removeGroupMessage($foundGroupMessages)){
                                    $this->Message[ResponsesType::RESPONSE] = "Group Message Removed";
                                }else{
                                    $this->Message[ResponsesType::ERROR] = "Unable to remove the Groupedcontact";
                                }
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to find the contact in the company";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the company user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            } elseif ($this->getRequestedService() == AvailableServices::GET_DASHBOARD) {
                /** Get All company Users */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $dashboard = $this->ServiceManager->getDashboard($companyUser->getCompany());
                        if($dashboard){
                            $this->Message[ResponsesType::RESPONSE] = $dashboard;
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Failed;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_COMPANY_USERS) {
                /** Get All company Users */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $users = $this->ServiceManager->getUsersByCompany($companyUser->getCompany());
                        if($users){
                            $this->Message[ResponsesType::RESPONSE] = $users;
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Failed;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
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
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_CAMPAIGN) {
                /** Get All company Campains */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if($found->getPrivilege()->getId()<3){
                            $Campaigns = $this->ServiceManager->getALLCampaignsByCompany($companyUser->getCompany());
                            $this->Message[ResponsesType::RESPONSE] = $Campaigns;
                        }else{
                            $Campaigns = $this->ServiceManager->getCampaignsByCompanyAndUser($companyUser->getCompany(),$found);
                            $this->Message[ResponsesType::RESPONSE] = $Campaigns;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANIES) {
                /** Get All company Campains */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if($found->getPrivilege()->getId() == 1){
                            $Campaigns = $this->ServiceManager->getAllCompanies();
                            $this->Message[ResponsesType::RESPONSE] = $Campaigns;
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_ACTIVE_COMPANIES) {
                /** Get All company Campains */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if($found->getPrivilege()->getId() == 1){
                            $Campaigns = $this->ServiceManager->getAllActiveCompanies();
                            $this->Message[ResponsesType::RESPONSE] = $Campaigns;
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_NOT_ACTIVE_COMPANIES) {
                /** Get All company Campains */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if($found->getPrivilege()->getId() == 1){
                            $Campaigns = $this->ServiceManager->getAllNotActiveCompanies();
                            $this->Message[ResponsesType::RESPONSE] = $Campaigns;
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
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
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_CONTACTS) {
                /** Get All company Contacts */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $companyContatcts = $this->ServiceManager->getContactsByCampany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $companyContatcts;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUPS) {
                /** Get All company Groups */
                $found = $this->getMainUser();
                if ($found) {
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $companyGroups = $this->ServiceManager->getGroupsByCampany($companyUser->getCompany());
                        $this->Message[ResponsesType::RESPONSE] = $companyGroups;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUP_CONTACTS) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);
                            if($foundGroup && $foundGroup->getCompany()->getId() == $companyUser->getCompany()->getId()){
                                $foundContact = $this->ServiceManager->getContactsByGroup($foundGroup);
                                $this->Message[ResponsesType::RESPONSE] = $foundContact;
                            }else{
                                $this->Message[ResponsesType::ERROR] = "there is no contacts in the company group";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUP_MESSAGES) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $foundGroupMessages = $this->ServiceManager->getGroupMessagesOfUser($found);
                        $this->Message[ResponsesType::RESPONSE] = $foundGroupMessages;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_SENT_MESSAGES) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        $foundSentMessages = $this->ServiceManager->getSendMessagesOfUser($found);
                        $this->Message[ResponsesType::RESPONSE] = $foundSentMessages;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            }elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUP_CONTACTS_NOT_IN_GROUP) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);
                            if($foundGroup && $foundGroup->getCompany()->getId() == $companyUser->getCompany()->getId()){
                                $foundContact = $this->ServiceManager->getContactsNotInGroup($foundGroup);
                                $this->Message[ResponsesType::RESPONSE] = $foundContact;
                            }else{
                                $this->Message[ResponsesType::ERROR] = "there is no contacts in the company group";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUP_CONTACTS_IN_GROUP) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);
                            if($foundGroup && $foundGroup->getCompany()->getId() == $companyUser->getCompany()->getId()){
                                $foundContact = $this->ServiceManager->getContactsInGroup($foundGroup);
                                $this->Message[ResponsesType::RESPONSE] = $foundContact;
                            }else{
                                $this->Message[ResponsesType::ERROR] = "there is no contacts in the company group";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_COMPANY_GROUPED_CONTACTS_IN_GROUP) {
                /** get all company group contacts */
                $found = $this->getMainUser();
                if($found){
                    $companyUser = $this->ServiceManager->getCompanyUserByUser($found);
                    if($companyUser){
                        if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                            $newGroup = new Group();
                            $newGroup->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                            /**
                             * @var Group $foundGroup
                             */
                            $foundGroup = $this->ServiceManager->getGroup($newGroup);
                            if($foundGroup && $foundGroup->getCompany()->getId() == $companyUser->getCompany()->getId()){
                                $foundContact = $this->ServiceManager->getGroupedContactsInGroup($foundGroup);
                                $this->Message[ResponsesType::RESPONSE] = $foundContact;
                            }else{
                                $this->Message[ResponsesType::ERROR] = "there is no contacts in the company group";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Company_User_Not_Found;
                    }
                }
            }elseif ($this->getRequestedService() == AvailableServices::GET_PRIVILEGES) {
                /** get all privileges */
                $found = $this->getMainUser();
                if ($found) {
                    $privilages = $this->ServiceManager->getLessPrivilege($found->getPrivilege());
                    $this->Message[ResponsesType::RESPONSE] = $privilages;
                }
            }elseif($this->getRequestedService() == AvailableServices::ACTIVATE_COMPANY_ACCOUNT) {
                /** Activate Company Account */
                $found = $this->getMainUser();
                if ($found->getPrivilege()->getId() == 1) {
                    if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                        $newCompany = new Company();
                        $newCompany->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                        /**
                         * @var Company $foundCompany
                         */
                        $foundCompany = $this->ServiceManager->getCompany($newCompany);
                        if($foundCompany){
                            $foundCompany->setIsActive(1);
                            if($this->ServiceManager->activateCompany($foundCompany)){
                                $this->Message[ResponsesType::RESPONSE] = "Account Activated!";
                            }else{
                                $this->Message[ResponsesType::RESPONSE] = "Account Activated!";
                            }
                        }else{
                            $this->Message[ResponsesType::RESPONSE] = "Company Not found Activated!";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                    }
                }
            } elseif($this->getRequestedService() == AvailableServices::DEACTIVATE_COMPANY_ACCOUNT) {
                /** Activate Company Account */
                $found = $this->getMainUser();
                if ($found->getPrivilege()->getId() == 1) {
                    if (FORMAT_ByItemID::isValidParam($this->getRequestParam())) {
                        $newCompany = new Company();
                        $newCompany->setId($this->getRequestParam()[FORMAT_ByItemID::ITEM_ID]);
                        /**
                         * @var Company $foundCompany
                         */
                        $foundCompany = $this->ServiceManager->getCompany($newCompany);
                        if($foundCompany){
                            $foundCompany->setIsActive(1);
                            if($this->ServiceManager->deActivateCompany($foundCompany)){
                                $this->Message[ResponsesType::RESPONSE] = "Account Deactivated!";
                            }else{
                                $this->Message[ResponsesType::RESPONSE] = "Account Not deActivated!";
                            }
                        }else{
                            $this->Message[ResponsesType::RESPONSE] = "Company Not found Activated!";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                    }
                }
            }else {
                $this->Message[ResponsesType::ERROR] = Responses::Unknown_Service_Request;
            }
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Unknown_Service_Request;
        }
    }
    public function Process(){
        if($this->isValidRequestFormat()){
            $this->ProcessRequest();
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Request_Format;
        }
    }
    private function getRandomString(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randString = "";
        for($i = 0; $i<36; $i++){
            $randString .=$characters[rand(0,strlen($characters)-1)];
        }
        return $randString;
    }

}