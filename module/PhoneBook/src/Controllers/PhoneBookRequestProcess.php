<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 9:24 PM
 */

namespace PhoneBook\Controllers;

use PhoneBook\Entities\Group;
use PhoneBook\Entities\Privilege;
use PhoneBook\Entities\User;
use PhoneBook\Services\Services;

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

    const ADD_USER = "add_user";
    const ADD_NEW_GROUP = "add_new_group";


    const GET_ALL_USERS = "get_all_users";
    const GET_ALL_GROUPS = "get_all_groups";
    const GET_ALL_PRIVILEGES = "get_all_privileges";


    const REMOVE_GROUP = "remove_group";
    const REMOVE_USER = "remove_user";
}
class FORMAT_AddUser extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const FULL_NAME = 'full_name';
    const PRIVILEGE = 'privilege';
}
class FORMAT_GROUP extends BasicEnum {
    const GROUP_NAME = 'name';
    const GROUP_DESCRIPTION = 'description';
}
class FORMAT_ItemID extends BasicEnum {
    const ITEM_ID = 'item_id';
}
class PhoneBookRequestProcess
{
    /**
     * @var Services $ServiceManager
     */
    protected $ServiceManager;
    protected $Request;
    protected $Message;

    /**
     * PhoneBookRequestProcess constructor.
     * @param Services $ServiceManager
     * @param $Request
     */
    public function __construct(Services $ServiceManager, $Request)
    {
        $this->ServiceManager = $ServiceManager;
        $this->Request = $Request;
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
    private function getMainUser()
    {
        $newUser = new User();
        $newUser->setUserPass($this->Request[RequestFormat::USER_PASS]);
        $newUser->setUserName($this->Request[RequestFormat::USER_NAME]);
        $foundUser = $this->ServiceManager->checkUser($newUser);
        if($foundUser){
            return $foundUser;
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Invalid_User_Account;
            return null;
        }
    }

    public function Process(){
        if($this->isValidRequestFormat()){
            $this->ProcessRequest();
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Invalid_Request_Format;
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
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Failed_Login;
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_PRIVILEGES) {
                /** get all privileges */
                $found = $this->getMainUser();
                if($found){
                    $privilages = $this->ServiceManager->getAllPrivilege();
                    $this->Message[ResponsesType::RESPONSE] = $privilages;
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_USER) {
                /** Add new user */
                $found = $this->getMainUser();
                if ($found) {
                    if (FORMAT_AddUser::isValidParam($this->getRequestParam())) {
                        if($found->getPrivilege()->getId() < 2){
                            $newUser = new User();
                            $newUser->setUserPass($this->getRequestParam()[FORMAT_AddUser::USER_PASS]);
                            $newUser->setUserName($this->getRequestParam()[FORMAT_AddUser::USER_NAME]);
                            $newUser->setFullName($this->getRequestParam()[FORMAT_AddUser::FULL_NAME]);
                            $newUser->setCreatedBy($found);
                            $newUser->setUpdatedBy($found);
                            $newPriv = new Privilege();
                            $newPriv->setId($this->getRequestParam()[FORMAT_AddUser::PRIVILEGE]);
                            /**
                             * @var Privilege $privilege
                             */
                            $privilege = $this->ServiceManager->getPrivilege($newPriv);
                            if($privilege){
                                $newUser->setPrivilege($privilege);
                                $addedUser = $this->ServiceManager->addUser($newUser);
                                if ($addedUser) {
                                    $this->Message[ResponsesType::RESPONSE] = $addedUser->getArray();
                                } else {
                                    $this->ServiceManager->removeUser($addedUser);
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
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::ADD_NEW_GROUP) {
                /** Add new Group */
                $found = $this->getMainUser();
                if ($found) {
                    if (FORMAT_GROUP::isValidParam($this->getRequestParam())) {
                        $newGroup = new Group();
                        $newGroup->setName($this->getRequestParam()[FORMAT_GROUP::GROUP_NAME]);
                        $newGroup->setDescription($this->getRequestParam()[FORMAT_GROUP::GROUP_DESCRIPTION]);
                        $newGroup->setCreatedBy($found);
                        $newGroup->setUpdatedBy($found);
                        $foundGroup = $this->ServiceManager->addNewGroup($newGroup);
                        if($foundGroup){
                            $this->Message[ResponsesType::RESPONSE] = $foundGroup->getArray();
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = Responses::Invalid_Param;
                    }
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            }elseif ($this->getRequestedService() == AvailableServices::GET_ALL_USERS) {
                /** Get All company Users */
                $found = $this->getMainUser();
                if ($found) {
                    $allUsers = $this->ServiceManager->getAllUsers();
                    if($allUsers){
                        $this->Message[ResponsesType::RESPONSE] = $allUsers;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Failed;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::GET_ALL_GROUPS) {
                /** Get All company Users */
                $found = $this->getMainUser();
                if ($found) {
                    $allGroups = $this->ServiceManager->getAllGroup();
                    if($allGroups){
                        $this->Message[ResponsesType::RESPONSE] = $allGroups;
                    }else{
                        $this->Message[ResponsesType::ERROR] = Responses::Failed;
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_GROUP) {
                /** Remove SMS Port */
                if (FORMAT_ItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getPrivilege()->getId() == 1){
                        $newGroup = new Group();
                        $newGroup->setId($this->getRequestParam()[FORMAT_ItemID::ITEM_ID]);
                        if($this->ServiceManager->removeGroup($newGroup)){
                            $this->Message[ResponsesType::RESPONSE] = $newGroup->getArray();
                        }else{
                            $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                        }
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Permission_Denied;
                }
            } elseif ($this->getRequestedService() == AvailableServices::REMOVE_USER) {
                /** Log in user */
                if (FORMAT_ItemID::isValidParam($this->getRequestParam())) {
                    $found = $this->getMainUser();
                    if($found && $found->getId() != $this->getRequestParam()[FORMAT_ItemID::ITEM_ID]){
                        $newUser = new User();
                        $newUser->setId($this->getRequestParam()[FORMAT_ItemID::ITEM_ID]);
                        $foundUser = $this->ServiceManager->getUser($newUser);
                        /**
                         * @var User $foundUser
                         */
                        if($foundUser){
                            if($this->ServiceManager->removeUser($newUser)){
                                $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                            }else{
                                $this->Message[ResponsesType::ERROR] = "Unable to remove the user";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Unable to find the user";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = "You cannot remove your current account!!";
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = Responses::Failed;
                }

            }
        }else{
            $this->Message[ResponsesType::ERROR] = Responses::Unknown_Service_Request;
        }
    }



}