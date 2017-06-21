<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:28 PM
 */

namespace WedeChurch\Controllers;

use WedeChurch\Entities\Privilege;
use WedeChurch\Entities\User;
use WedeChurch\Services\Service;

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
    const AUTHENTICATE = 'log_in';
    const REGISTER = 'register';
}
class FORMAT_ByItemID extends BasicEnum {
    const ITEM_ID = 'item_id';
}
class FORMAT_REGISTER extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const FULL_NAME = 'full_name';
    const Email     = 'email';
    const PHONE     = 'phone';
}
class APIProcess1
{
    /**
     * @var Service $ServiceManager;
     */
    protected $ServiceManager;
    protected $Request;
    protected $Message;

    /**
     * APIProcess1 constructor.
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
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Failed_Login;
                }
                return true;
            } elseif ($this->getRequestedService() == AvailableServices::AUTHENTICATE) {
                /** Log in user */
                $found = $this->getMainUser();
                if ($found) {
                    $this->Message[ResponsesType::RESPONSE] = $found->getArray();
                } else {
                    $this->Message[ResponsesType::ERROR] = Responses::Failed_Login;
                }
            } elseif ($this->getRequestedService() == AvailableServices::REGISTER) {
                /** Sign up new user */
                if (FORMAT_REGISTER::isValidParam($this->getRequestParam())) {
                    $superAdmin = $this->getSuperAdmin();
                    if($superAdmin){
                        $newUser = new User();
                        $newUser->setUserPass($this->getRequestParam()[FORMAT_REGISTER::USER_PASS]);
                        $newUser->setUserName($this->getRequestParam()[FORMAT_REGISTER::USER_NAME]);
                        $newUser->setFullName($this->getRequestParam()[FORMAT_REGISTER::FULL_NAME]);
                        $newUser->setEmail($this->getRequestParam()[FORMAT_REGISTER::Email]);
                        $newUser->setPhone($this->getRequestParam()[FORMAT_REGISTER::PHONE]);
                        $newUser->setUpdatedBy($superAdmin);
                        $newUser->setCreatedBy($superAdmin);
                        $newPriv = new Privilege();
                      //  print_r($newUser);
                        $newPriv->setId(3);
//                         Get Privilege
                        $privilege = $this->ServiceManager->getPrivilege($newPriv);
                        if($privilege){
                            $newUser->setPrivilege($privilege);
                            $addedUser = $this->ServiceManager->addUser($newUser);
                            if ($addedUser) {
                                $this->Message[ResponsesType::RESPONSE] = $addedUser->getArray();
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to add new User";
                            }
                        }else{
                            $this->Message[ResponsesType::ERROR] = "Failed to find privilegs";
                        }
                    }else{
                        $this->Message[ResponsesType::ERROR] = "There is no super admin to add new user";
                    }
                }else{
                    $this->Message[ResponsesType::ERROR] = "Invalid Registration format";
                }
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
