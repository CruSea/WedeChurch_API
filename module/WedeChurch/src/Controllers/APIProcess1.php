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
use WedeChurch\Entities\Church;
use WedeChurch\Entities\Event;
use WedeChurch\Entities\Event_category;

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
    const CHURCH_REGISTER = 'church_register';
    const CHURCH_GET = 'church_get';
    const Event_Get  =  'event_get';
}
class FORMAT_ByItemID extends BasicEnum {
    const ITEM_ID = 'item_id';
}
class FORMAT_REGISTER extends BasicEnum {
    const USER_NAME  = 'user_name';
    const USER_PASS  = 'user_pass';
    const First_NAME = 'first_name';
    const Last_NAME  = 'last_name';
    const Email      = 'email';
    const PHONE      = 'phone';
    const SEX        = 'sex';
    const Country    = 'country';
}

class FORMAT_GET_CHURCH extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const ID       = 'id';
}
class FORMAT_GET_EVENT extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const ID       = 'id';
}

class FORMAT_CHURCH_REGISTER extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const CHURCH_NAME = 'church_name';
    const Country   = 'country';
    CONST Cities    = 'cities';
    const PHONE     = 'phone';
    const Location  = 'location';
    const Longitude = 'longitude';
    const Latitude  = 'latitude';
    const WebUrl  ='weburl';
    const Denomination_id = 'denomination_id';
    const Banner  ='banner';
    const Description = 'description';
    const Logo   = 'logo';
    const Parent_church_id = 'parent_church_id';
    const State   = 'state';


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
                    if ($superAdmin) {
                        $newUser = new User();
                        $newUser->setUserPass($this->getRequestParam()[FORMAT_REGISTER::USER_PASS]);
                        $newUser->setUserName($this->getRequestParam()[FORMAT_REGISTER::USER_NAME]);
                        $newUser->setFirstName($this->getRequestParam()[FORMAT_REGISTER::First_NAME]);
                        $newUser->setLastName($this->getRequestParam()[FORMAT_REGISTER::Last_NAME]);
                        $newUser->setCountry($this->getRequestParam()[FORMAT_REGISTER::Country]);
                        $newUser->setEmail($this->getRequestParam()[FORMAT_REGISTER::Email]);
                        $newUser->setPhone($this->getRequestParam()[FORMAT_REGISTER::PHONE]);
                        $newUser->setSex($this->getRequestParam()[FORMAT_REGISTER::SEX]);
                        $newUser->setUpdatedBy($superAdmin);
                        $newUser->setCreatedBy($superAdmin);
                        $newPriv = new Privilege();
                        $newPriv->setId(1);
//                         Get Privilege
                        $privilege = $this->ServiceManager->getPrivilege($newPriv);
                        if ($privilege) {
                            $newUser->setPrivilege($privilege);
                            $addedUser = $this->ServiceManager->addUser($newUser);
                            if ($addedUser) {
                                $this->Message[ResponsesType::RESPONSE] = $addedUser->getArray();
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to add new User";
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = "Failed to find privilegs";
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = "There is no super admin to add new user";
                    }

                } else {
                    $this->Message[ResponsesType::ERROR] = "Invalid Registration format";
                }

            } elseif ($this->getRequestedService() == AvailableServices::CHURCH_GET) {
                /** Sign up new user */
                if (FORMAT_GET_CHURCH::isValidParam($this->getRequestParam())) {
                      if ($this->getRequestParam()[FORMAT_GET_CHURCH::ID]){
                          $newChurch = new Church();
                          $newChurch->setId($this->getRequestParam()[FORMAT_GET_CHURCH::ID]);
                          $foundChurch = $this->ServiceManager->getChurch($newChurch);
                          $this->Message[ResponsesType::RESPONSE] = $foundChurch->getArray();
                      }elseif($this->getRequestParam()[FORMAT_GET_CHURCH::ID] == null)
                          $foundChurch = $this->ServiceManager->getAllChurch();
                          $this->Message[ResponsesType::RESPONSE] = $foundChurch;

                    }
                }elseif ($this->getRequestedService() == AvailableServices::Event_Get) {
                /** Sign up new user */
                if (FORMAT_GET_EVENT::isValidParam($this->getRequestParam())) {
                    if ($this->getRequestParam()[FORMAT_GET_EVENT::ID]){
                      $newEvent = new Event();
                      $newEvent->setId($this->getRequestParam()[FORMAT_GET_EVENT::ID]);
                      $foundEvent = $this->ServiceManager->getEvent($newEvent);
                      $this->Message[ResponsesType::RESPONSE] =  $foundEvent;
                    }elseif($this->getRequestParam()[FORMAT_GET_EVENT::ID] == null)
                        $foundEvent = $this->ServiceManager->getAllEvent();
                        $this->Message[ResponsesType::RESPONSE] =  $foundEvent;
                }
            }
                elseif ($this->getRequestedService() == AvailableServices::CHURCH_REGISTER) {
                    /** add  new church */

                    if (FORMAT_CHURCH_REGISTER::isValidParam($this->getRequestParam())) {

                        $user = $this->getMainUser();

                        if ($user) {

                            $newChurch = new Church();
                            $newChurch->setName($this->getRequestParam()[FORMAT_CHURCH_REGISTER::CHURCH_NAME]);
                            $newChurch->setCountry($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Country]);
                            $newChurch->setCities($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Cities]);
                            $newChurch->setState($this->getRequestParam()[FORMAT_CHURCH_REGISTER::State]);
                            $newChurch->setPhone($this->getRequestParam()[FORMAT_CHURCH_REGISTER::PHONE]);
                            $newChurch->setLocation($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Location]);
                            $newChurch->setLatitude($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Latitude]);
                            $newChurch->setLongitude($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Longitude]);
                            $newChurch->setWebUrl($this->getRequestParam()[FORMAT_CHURCH_REGISTER::WebUrl]);
                            $newChurch->setDescription($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Description]);
                            $newChurch->setLogo($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Logo]);
                            $newChurch->setDenomination($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Denomination_id]);
                            $newChurch->setBanner($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Banner]);
                            $newChurch->setParentChurchId($this->getRequestParam()[FORMAT_CHURCH_REGISTER::Parent_church_id]);
                            $newChurch->setUpdatedBy($user->getId());
                            $newChurch->setCreatedBy($user->getId());

                            $addedChurch = $this->ServiceManager->addChurch($newChurch);
                            if ($addedChurch) {
                                $this->Message[ResponsesType::RESPONSE] = $addedChurch->getArray();
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to add new church";
                            }
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = "Invalid user to add church";
                    }
                }
            } else {
                $this->Message[ResponsesType::ERROR] = "Invalid church Registration format";

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
