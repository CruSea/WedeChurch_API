<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:28 PM
 */

namespace WedeChurch\Controllers;


use WedeChurch\Entities\Favorite;
use WedeChurch\Entities\Privilege;
use WedeChurch\Entities\User;
use WedeChurch\Services\Service;
use WedeChurch\Entities\Church;
use WedeChurch\Entities\Event;
use WedeChurch\Entities\Event_category;
use WedeChurch\Entities\Denomination;


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
    const REGISTER     = 'register';
    const CHURCH_REGISTER = 'church_register';
    const CHURCH_GET   = 'church_get';
    const Event_Get    = 'event_get';
    const Favorite_get ='favorite_get';
    const EVENT_REGISTER = 'event_register';
    const DENOMINATION_GET = 'denomination_get';
    const User_update  ='user_update';
    const CHURCH_UPDATE='church_update';
    const Event_Update = 'event_update';
    const Event_Remove = 'event_remove';
    const User_Remove  =  'user_remove';
    const Favorite_Register = 'favorite_register';
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
    const ID        = 'id';
}

class FORMAT_FAVORITE extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const  ID  = 'id';
}

class FORMAT_GET_DENOMINATION extends BasicEnum {
    const USER_NAME = 'user_name';
    const USER_PASS = 'user_pass';
    const ID        = 'id';
}

class FORMAT_CHURCH_REGISTER extends BasicEnum {

    const NAME        = 'church_name';
    const COUNTRY     = 'country';
    CONST CITIES      = 'cities';
    const PHONE       = 'phone';
    const LOCATION    = 'location';
    const LONGITUDE   = 'longitude';
    const LATITUDE    = 'latitude';
    const WEBURL      = 'weburl';
    const DENOMINATION_ID = 'denomination_id';
    const BANNER      = 'banner';
    const DESCRIPTION = 'description';
    const LOGO        = 'logo';
    const PARENT_CHURCH_ID = 'parent_church_id';
    const STATE       = 'state';
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
        $hhh = array($this->Request[RequestFormat::PARAM]);
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
                        $newPriv->setId(2);
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

            }elseif ($this->getRequestedService() == AvailableServices::Favorite_Register) {
                /** ADD NEW FAVORITE */
                if (FORMAT_FAVORITE::isValidParam($this->getRequestParam())) {
                    $USER = $this->getMainUser();
                    if ($USER) {
                        $favorite = new Favorite();
                        $favorite->setUser($USER);
                        $favorite->setUpdatedBy($USER);
                        $favorite->setCreatedBy($USER);
                        $church = new Church();
                        $church ->setId($this->getRequestParam()[FORMAT_FAVORITE::ID]);
                        $fchurch = $this->ServiceManager->getChurch($church);
                        if ($fchurch){
                            $favorite->setChurch($fchurch);
                            $addedFav = $this->ServiceManager->addFavorite($favorite);
                            if ($addedFav) {
                                $this->Message[ResponsesType::RESPONSE] = $addedFav->getArray();
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to add favorite";
                            }
                        }
                        else { $this->Message[ResponsesType::ERROR] = "invalid church is given";}

                    }else {
                    $this->Message[ResponsesType::ERROR] = "Invalid favorite format";
                }
                }
            } elseif ($this->getRequestedService() == AvailableServices::Favorite_get) {
                //favorite get
                if (FORMAT_FAVORITE::isValidParam($this->getRequestParam())) {
                        $USER = $this->getMainUser();
                        $favChurch = new Favorite();
                        $favChurch->setUser($USER);
                        $foundFavChurch = $this->ServiceManager->getUserFavorite($favChurch);
                        $this->Message[ResponsesType::RESPONSE] = $foundFavChurch;
                }
            }
            elseif ($this->getRequestedService() == AvailableServices::CHURCH_GET) {
                //favorite get
                if (FORMAT_GET_CHURCH::isValidParam($this->getRequestParam())) {
                    if ($this->getRequestParam()[FORMAT_GET_CHURCH::ID]) {
                        $newChurch = new Church();
                        $newChurch->setId($this->getRequestParam()[FORMAT_GET_CHURCH::ID]);
                        $foundChurch = $this->ServiceManager->getChurch($newChurch)->getArray();
                        $this->Message[ResponsesType::RESPONSE] = $foundChurch;

                    } elseif ($this->getRequestParam()[FORMAT_GET_CHURCH::ID] == null)
                        $foundChurch = $this->ServiceManager->getAllChurch();
                    $this->Message[ResponsesType::RESPONSE] = $foundChurch;
                }
            }

            elseif ($this->getRequestedService() == AvailableServices::DENOMINATION_GET) {
                    //denomination get

                    if (FORMAT_GET_DENOMINATION::isValidParam($this->getRequestParam())) {

                        if ($this->getRequestParam()[FORMAT_GET_DENOMINATION::ID]) {
                            $denominations = new Denomination();
                            $denominations->setId($this->getRequestParam()[FORMAT_GET_DENOMINATION::ID]);
                            $foundDenominations = $this->ServiceManager->getDenomination($denominations);
                            $this->Message[ResponsesType::RESPONSE] = $foundDenominations;

                        } elseif ($this->getRequestParam()[FORMAT_GET_DENOMINATION::ID] == null)
                            $foundDenominations = $this->ServiceManager->getAllDenomination();
                        $this->Message[ResponsesType::RESPONSE] = $foundDenominations;
                    }

            } elseif ($this->getRequestedService() == AvailableServices::Event_Get) {
                /** Sign up new user */
                if (FORMAT_GET_EVENT::isValidParam($this->getRequestParam())) {
                    if ($this->getRequestParam()[FORMAT_GET_EVENT::ID]) {
                        $newEvent = new Event();
                        $newEvent->setId($this->getRequestParam()[FORMAT_GET_EVENT::ID]);
                       $foundEvent = $this->ServiceManager->getEvent($newEvent)->getArray();
                            $this->Message[ResponsesType::RESPONSE] = $foundEvent;
                        }
                    } elseif ($this->getRequestParam()[FORMAT_GET_EVENT::ID] == null)
                {
                    $foundEvent = $this->ServiceManager->getAllEvent();
                    $this->Message[ResponsesType::RESPONSE] = $foundEvent;
                }
            } elseif ($this->getRequestedService() == AvailableServices::CHURCH_REGISTER) {
                /** add  new church */

                if (FORMAT_CHURCH_REGISTER::isValidParam($this->getRequestParam())) {
                    $user = $this->getMainUser();
                    if ($user) {
                        $newChurch = new Church();
                        $newChurch->setName($this->getRequestParam()[FORMAT_CHURCH_REGISTER::NAME]);
                        $newChurch->setCountry($this->getRequestParam()[FORMAT_CHURCH_REGISTER::COUNTRY]);
                        $newChurch->setCities($this->getRequestParam()[FORMAT_CHURCH_REGISTER::CITIES]);
                        $newChurch->setLocation($this->getRequestParam()[FORMAT_CHURCH_REGISTER::LOCATION]);
                        $newChurch->setLatitude($this->getRequestParam()[FORMAT_CHURCH_REGISTER::LATITUDE]);
                        $newChurch->setLongitude($this->getRequestParam()[FORMAT_CHURCH_REGISTER::LONGITUDE]);
                        $newChurch->setLogo($this->getRequestParam()[FORMAT_CHURCH_REGISTER::LOGO]);
                        $newChurch->setWebUrl($this->getRequestParam()[FORMAT_CHURCH_REGISTER::WEBURL]);
                        $newChurch->setBanner($this->getRequestParam()[FORMAT_CHURCH_REGISTER::BANNER]);
                        $newChurch->setState($this->getRequestParam()[FORMAT_CHURCH_REGISTER::STATE]);
                        $newChurch->setDescription($this->getRequestParam()[FORMAT_CHURCH_REGISTER::DESCRIPTION]);
                        $newChurch->setParentChurchId($this->getRequestParam()[FORMAT_CHURCH_REGISTER::PARENT_CHURCH_ID]);
                        $newChurch->setPhone($this->getRequestParam()[FORMAT_CHURCH_REGISTER::PHONE]);
                        $newChurch->setUpdatedBy($user);
                        $newChurch->setCreatedBy($user);
                        $newdenomination = new Denomination();
                        $newdenomination->setId(1);
//                         Get Denomination
                        $denomination = $this->ServiceManager->getDenomination($newdenomination);
                        if ($denomination) {
                           // $newChurch->setDenomination($denomination);
                            $addedChurch = $this->ServiceManager->addChurch($newChurch);
                            if ($addedChurch) {
                                $this->Message[ResponsesType::RESPONSE] = $addedChurch->getArray();
                            } else {
                                $this->Message[ResponsesType::ERROR] = "Failed to add new church";
                            }
                        } else {
                            $this->Message[ResponsesType::ERROR] = "Failed to find denomination";
                        }
                    } else {
                        $this->Message[ResponsesType::ERROR] = "user is not allowed to add new church";
                    }

                } else {
                    $this->Message[ResponsesType::ERROR] = "Invalid church Registration format";
                }
            } else {
                $this->Message[ResponsesType::ERROR] = "Invalid Request format to the API";
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
