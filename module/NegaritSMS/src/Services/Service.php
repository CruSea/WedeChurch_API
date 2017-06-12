<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:34 AM
 */

namespace NegaritSMS\Services;
use Doctrine\ORM\EntityManager;
use NegaritSMS\DataModels\Dashboard;
use NegaritSMS\DataModels\SentMessages;
use NegaritSMS\DataModels\SMSCampaignStatus;
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
use NegaritSMS\Entities\ReceivedMessage;
use NegaritSMS\Entities\SendMessage;
use NegaritSMS\Entities\SMSPort;
use NegaritSMS\Entities\User;

class Service implements ServiceMethods
{
    /**
     * @var EntityManager $EntityManager
     */
    protected $EntityManager;

    /**
     * Service constructor.
     * @param EntityManager $EntityManager
     */
    public function __construct(EntityManager $EntityManager)
    {
        $this->EntityManager = $EntityManager;
    }

    public function getDashboard(Company $company)
    {
        $foundUsers = $this->EntityManager->getRepository(User::class)->findAll();
        $newDashboard = new Dashboard();
        $newDashboard->setUsers(count($this->getUsersByCompany($company)));
        $newDashboard->setSentMessages(count($this->getALLSendMessageByCompany($company)));
        $newDashboard->setReceivedMessages(count($this->getReceivedMessagesByCompany($company)));
        $newDashboard->setCampaigns(count($this->getALLCampaignsByCompany($company)));
        $newDashboard->setContacts(count($this->getContactsByCampany($company)));
        $newDashboard->setLastMessages($this->getLastSentMessages($company));
        $newDashboard->setCampaignsStatus($this->getSMSCampaignStatus($company));
        return $newDashboard->getArray();
    }

    public function getSMSCampaignStatus(Company $company)
    {
        $campaigns = [];
        $allCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($allCampaigns as $campaign){
            /**
             * @var Campaign $campaign
             */
            if($campaign->getCompany()->getId() == $company->getId()){
                $newSMSCampaignStatus = new SMSCampaignStatus();
                $newSMSCampaignStatus->setName($campaign->getName());
                $newSMSCampaignStatus->setSentMessages(count($this->getSendMessagesByCampaign($campaign)));
                $newSMSCampaignStatus->setReceivedMessages(count($this->getSendMessagesByCampaign($campaign)));
                $newSMSCampaignStatus->setCreatedBy($campaign->getCreatedBy()->getFullName());
                $newSMSCampaignStatus->setCreatedDate($campaign->getCreatedDate());
                $campaigns[] = $newSMSCampaignStatus->getArray();
            }
        }
        return $campaigns;
    }

    public function getLastSentMessages(Company $company)
    {
        $messages = [];
        $allMessages = $this->EntityManager->getRepository(SendMessage::class)->findAll();
        foreach ($allMessages as $message){
            /**
             * @var SendMessage $message
             */
            if($message->getCampaign()->getCompany()->getId() == $company->getId()){
                $newSentMessage = new SentMessages();
                $newSentMessage->setMessage($message->getMessage());
                $newSentMessage->setCreatedBy($message->getCreatedBy()->getFullName());
                $newSentMessage->setCampaignName($message->getCampaign()->getName());
                $newSentMessage->setDateTime($message->getCreatedDate());
                $messages[] = $newSentMessage->getArray();
            }
        }
        if(count($messages)>8){
            $messages = array_slice(array_reverse($messages),0,8);
        }else{
            $messages = array_reverse($messages);
        }
        return $messages;
    }


    public function addUser(User $user)
    {
        $user->setId(null);
        $user->setIsActive(1);
        $user->setIsDeleted(0);
        $user->setCreatedDate(new \DateTime('now'));
        $user->setUpdatedDate(new \DateTime('now'));
        $user->setUserPass(sha1($user->getUserPass()));
        $this->EntityManager->persist($user);
        $this->EntityManager->flush();
        if($user->getId()){
            return $user;
        }else{
            return null;
        }
    }

    public function getUser(User $user)
    {
        if($user->getId()){
            $foundUser = $this->EntityManager->getRepository(User::class)->find($user->getId());
            return $foundUser;
        }else{
            return null;
        }
    }

    public function getUserByEmail(User $user)
    {
        $allUser = $this->EntityManager->getRepository(User::class)->findAll();
        foreach ($allUser as $_user){
            /**
             * @var User $_user
             */
            if($user->getEmail() == $_user->getEmail()){
                return $_user;
            }
        }
        return null;
    }

    public function getUserByID(User $user)
    {
        $allUser = $this->EntityManager->getRepository(User::class)->findAll();
        foreach ($allUser as $_user){
            /**
             * @var User $_user
             */
            if($user->getId() == $_user->getId()){
                return $_user;
            }
        }
        return null;
    }

    public function checkUser(User $user)
    {
        try{
            $allUsers = $this->EntityManager->getRepository(User::class)->findAll();
            foreach ($allUsers as $_user){
                /**
                 * @var User $_user
                 */
                if(($_user->getUserPass() == sha1($user->getUserPass())) &&
                    (($_user->getUserName() == $user->getUserName()) || ($_user->getEmail() == $user->getEmail()))){
                    return $_user;
                }
            }
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
        return null;
    }

    public function updateUser(User $user)
    {
        try{
            if($user->getId()){
                $this->EntityManager->persist($user);
                $this->EntityManager->flush();
                if($user->getId()){
                    return $user;
                }else{
                    return null;
                }
            }
        }catch (\Exception $exception){
            print_r($exception);
        }
    }

    public function removeUser(User $user)
    {
        if($user){
            /**
             * @var User $foundUser
             */
            $foundUser = $this->getUser($user);
            if($foundUser){
                $this->EntityManager->remove($foundUser);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addCompany(Company $company)
    {
        $company->setId(null);
        $company->setIsActive(0);
        $company->setIsDeleted(0);
        $company->setCreatedDate(new \DateTime('now'));
        $company->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($company);
        $this->EntityManager->flush();
        if($company->getId()){
            return $company;
        }else{
            return null;
        }
    }

    public function activateCompany(Company $company)
    {
        if($company->getId()){
            $company->setIsActive(1);
            $company->setIsDeleted(0);
            $this->EntityManager->persist($company);
            $this->EntityManager->flush();
            if($company->getisActive()){
                return true;
            }else{
                return null;
            }
        }
        return null;
    }

    public function deActivateCompany(Company $company)
    {
        if($company->getId()){
            $company->setIsActive(0);
            $this->EntityManager->persist($company);
            $this->EntityManager->flush();
            if(!$company->getisActive()){
                return true;
            }else{
                return null;
            }
        }
        return null;
    }

    public function getCompany(Company $company)
    {
        if($company->getId()){
            $foundCompany = $this->EntityManager->getRepository(Company::class)->find($company->getId());
            return $foundCompany;
        }else{
            return null;
        }
    }

    public function getAllCompanies()
    {
        $Companies = [];
        $foundCompanies = $this->EntityManager->getRepository(Company::class)->findAll();
        if($foundCompanies){
            foreach ($foundCompanies as $company){
                /**
                 * @var Company $company
                 */
                if(!$company->getisDeleted()){
                    $Companies[] = $company->getArray();
                }
            }
        }
        return $Companies;
    }

    public function getAllActiveCompanies()
    {
        $Companies = [];
        $foundCompanies = $this->EntityManager->getRepository(Company::class)->findAll();
        if($foundCompanies){
            foreach ($foundCompanies as $company){
                /**
                 * @var Company $company
                 */
                if(!$company->getisDeleted() && $company->getisActive()){
                    $Companies[] = $company->getArray();
                }
            }
        }
        return $Companies;
    }

    public function getAllNotActiveCompanies()
    {
        $Companies = [];
        $foundCompanies = $this->EntityManager->getRepository(Company::class)->findAll();
        if($foundCompanies){
            foreach ($foundCompanies as $company){
                /**
                 * @var Company $company
                 */
                if(!$company->getisDeleted() && !$company->getisActive()){
                    $Companies[] = $company->getArray();
                }
            }
        }
        return $Companies;
    }

    public function removeCompany(Company $company)
    {
        if($company->getId()){
            /**
             * @var Company $foundUser
             */
            $foundCompany = $this->getCompany($company);
            if($foundCompany){
                $this->EntityManager->remove($foundCompany);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }


    public function addCompanyUser(CompanyUser $companyUser)
    {
        $companyUser->setId(null);
        $companyUser->setIsActive(1);
        $companyUser->setIsDeleted(0);
        $companyUser->setCreatedDate(new \DateTime('now'));
        $companyUser->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($companyUser);
        $this->EntityManager->flush();
        if($companyUser->getId()){
            return $companyUser;
        }else{
            return null;
        }
    }

    public function getCompanyUserByID(CompanyUser $companyUser)
    {
        if($companyUser->getId()){
            $foundCompanyUser = $this->EntityManager->getRepository(CompanyUser::class)->find($companyUser->getId());
            return $foundCompanyUser;
        }else{
            return null;
        }
    }

    public function getCompanyUserByUser(User $user)
    {
        if($user->getId()){
            $allCompanyUsers = $this->EntityManager->getRepository(CompanyUser::class)->findAll();
            if($allCompanyUsers){
                foreach ($allCompanyUsers as $companyUser){
                    /**
                     * @var CompanyUser $companyUser
                     */;
                    if(($companyUser) && ($companyUser->getUser()) && $companyUser->getUser()->getId() == $user->getId()){
                        return $companyUser;
                    }
                }
            }
        }
        return null;
    }

    public function getUsersByCompany(Company $company)
    {
        $foundUsers = [];
        if($company->getId()){
            $allCompanyUsers = $this->EntityManager->getRepository(CompanyUser::class)->findAll();
            foreach ($allCompanyUsers as $companyUser){
                /**
                 * @var CompanyUser $companyUser
                 */
                if($companyUser->getCompany()->getId() == $company->getId()){
                    $foundUsers[] = $companyUser->getUser()->getArray();
                }
            }
        }
        return $foundUsers;
    }

    public function removeCompanyUser(CompanyUser $companyUser)
    {
        if($companyUser->getId()){
            /**
             * @var Company $foundUser
             */
            $foundCompanyUser = $this->getCompanyUserByID($companyUser);
            if($foundCompanyUser){
                $this->EntityManager->remove($foundCompanyUser);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function removeCompanyUserByUser(User $user)
    {
        $state = false;
        if($user->getId()){
            $allCompanyUsers = $this->EntityManager->getRepository(CompanyUser::class)->findAll();
            foreach ($allCompanyUsers as $companyUser){
                /**
                 * @var CompanyUser $companyUser
                 */
                if($companyUser->getUser()->getId() == $user->getId()){
                    if($this->removeCompanyUser($companyUser)){
                        $state = true;
                    }
                }
            }
        }
        return $state;
    }

    public function removeCompanyUsersByCompany(Company $company)
    {
        $state = false;
        if($company->getId()){
            $allCompanyUsers = $this->EntityManager->getRepository(CompanyUser::class)->findAll();
            foreach ($allCompanyUsers as $companyUser){
                /**
                 * @var CompanyUser $companyUser
                 */
                if($companyUser->getCompany()->getId() == $company->getId()){
                    if($this->removeCompanyUser($companyUser)){
                        $state = true;
                    }
                }
            }
        }
        return $state;
    }

    public function addPrivilege(Privilege $privilege)
    {
        $privilege->setId(null);
        $privilege->setIsActive(1);
        $privilege->setIsDeleted(0);
        $privilege->setCreatedDate(new \DateTime('now'));
        $privilege->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($privilege);
        $this->EntityManager->flush();
        if($privilege->getId()){
            return $privilege;
        }else{
            return null;
        }
    }

    /**
     * @param Privilege $privilege
     * @return Privilege
     */
    public function getPrivilege(Privilege $privilege)
    {
        if($privilege->getId()){
            $foundPrivilege = $this->EntityManager->getRepository(Privilege::class)->find($privilege->getId());
            return $foundPrivilege;
        }else{
            return null;
        }
    }

    public function getAllPrivilege()
    {
        $foundPrivileges = [];
        $allPrivileges = $this->EntityManager->getRepository(Privilege::class)->findAll();
        foreach ($allPrivileges as $privilege){
            /**
             * @var Privilege $privilege
             */
            if($privilege->getId()>2){
                $foundPrivileges[] = $privilege->getArray();
            }
        }
        return $foundPrivileges;
    }
    public function getLessPrivilege(Privilege $privilege)
    {
        $foundPrivileges = [];
        $allPrivileges = $this->EntityManager->getRepository(Privilege::class)->findAll();
        foreach ($allPrivileges as $_privilege){
            /**
             * @var Privilege $_privilege
             */
            if($privilege->getId()<3){
                if($privilege->getId() <= $_privilege->getId()){
                    $foundPrivileges[] = $_privilege->getArray();
                }
            }else{
                if($privilege->getId() < $_privilege->getId()){
                    $foundPrivileges[] = $_privilege->getArray();
                }
            }
        }
        return $foundPrivileges;
    }

    public function addSMSPort(SMSPort $port)
    {
        $port->setId(null);
        $port->setIsActive(1);
        $port->setIsDeleted(0);
        $port->setCreatedDate(new \DateTime('now'));
        $port->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($port);
        $this->EntityManager->flush();
        if($port->getId()){
            return $port;
        }else{
            return null;
        }
    }

    public function getSMSPort(SMSPort $port)
    {
        if($port->getId()){
            $foundSMSPort = $this->EntityManager->getRepository(SMSPort::class)->find($port->getId());
            return $foundSMSPort;
        }else{
            return null;
        }
    }

    public function getSMSPortByCompanyAndName(Company $company, SMSPort $port)
    {
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $SMSPort){
            /**
             * @var SMSPort $SMSPort
             */
            if($SMSPort->getisActive() && ($SMSPort->getCompany()->getId() == $company->getId()) && ($SMSPort->getName() == $port->getName())){
                return $SMSPort;
            }
        }
        return null;
    }

    public function getSMSPortByDeviceIDAndSecret(SMSPort $SMSPort)
    {
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $_SMSPort){
            /**
             * @var SMSPort $_SMSPort
             */
            if($_SMSPort->getisActive() && ($_SMSPort->getDeviceID() == $SMSPort->getDeviceID()) && ($_SMSPort->getSecret() == $SMSPort->getSecret())){
                return $_SMSPort;
            }
        }
        return null;
    }

    public function getAllSMSPortsByCompany(Company $company)
    {
        $foundSMSPorts = [];
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $SMSPort){
            /**
             * @var SMSPort $SMSPort
             */
            if(!$SMSPort->getisDeleted() && ($SMSPort->getCompany()->getId() == $company->getId())){
                $foundSMSPorts[] = $SMSPort->getArray();
            }
        }
        return $foundSMSPorts;
    }

    public function getActiveSMSPortsByCompany(Company $company)
    {
        $foundSMSPorts = [];
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $SMSPort){
            /**
             * @var SMSPort $SMSPort
             */
            if($SMSPort->getisActive() && !$SMSPort->getisDeleted() && ($SMSPort->getCompany()->getId() == $company->getId())){
                $foundSMSPorts[] = $SMSPort->getArray();
            }
        }
        return $foundSMSPorts;
    }

    public function getAllSMSPorts()
    {
        $foundSMSPorts = [];
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $SMSPort){
            /**
             * @var SMSPort $SMSPort
             */
            if($SMSPort->getisActive() && !$SMSPort->getisDeleted()){
                $foundSMSPorts[] = $SMSPort->getArray();
            }
        }
        return $foundSMSPorts;
    }

    public function listAllSMSPorts()
    {
        $foundSMSPorts = [];
        $allSMSPorts = $this->EntityManager->getRepository(SMSPort::class)->findAll();
        foreach ($allSMSPorts as $SMSPort){
            /**
             * @var SMSPort $SMSPort
             */
            if($SMSPort->getisActive() && !$SMSPort->getisDeleted()){
                $foundSMSPorts[] = $SMSPort;
            }
        }
        return $foundSMSPorts;
    }


    public function removeSMSPorts(SMSPort $SMSPort)
    {
        if($SMSPort->getId()){
            /**
             * @var SMSPort $foundSMSPort
             */
            $foundSMSPort = $this->getSMSPort($SMSPort);
            if($foundSMSPort){
                $this->EntityManager->remove($foundSMSPort);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addNewCampaign(Campaign $campaign)
    {
        $campaign->setId(null);
        $campaign->setIsActive(1);
        $campaign->setIsDeleted(0);
        $campaign->setCreatedDate(new \DateTime('now'));
        $campaign->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($campaign);
        $this->EntityManager->flush();
        if($campaign->getId()){
            return $campaign;
        }else{
            return null;
        }
    }

    public function getCampaign(Campaign $campaign)
    {
        if($campaign->getId()){
            $foundCampaign= $this->EntityManager->getRepository(Campaign::class)->find($campaign->getId());
            return $foundCampaign;
        }else{
            return null;
        }
    }

    public function getCampaignByCompanyAndName(Company $company, Campaign $campaign)
    {
        $foundCampaigns = [];
        $foundAllCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($foundAllCampaigns as $_campaign){
            /**
             * @var Campaign $_campaign
             */
            if((!$_campaign->getisDeleted()) && ($_campaign->getCompany()->getId() == $company->getId()) && ($campaign->getName() == $_campaign->getName())){
                return $_campaign;
            }
        }
        return null;
    }

    public function getALLCampaignsByCompany(Company $company)
    {
        $foundCampaigns = [];
        $foundAllCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($foundAllCampaigns as $campaign){
            /**
             * @var Campaign $campaign
             */
            if((!$campaign->getisDeleted()) && ($campaign->getCompany()->getId() == $company->getId())){
                $campaign->setCampaignUsers($this->getCampaignUsersByCampaign($campaign));
                $foundCampaigns[] = $campaign->getArray();
            }
        }
        return $foundCampaigns;
    }

    public function listCampaignsBySMSPort(SMSPort $SMSPort)
    {
        $foundCampaigns = [];
        $foundAllCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($foundAllCampaigns as $campaign){
            /**
             * @var Campaign $campaign
             */
            if((!$campaign->getisDeleted()) && ($campaign->getSMSPort()->getId() == $SMSPort->getId())){
                $foundCampaigns[] = $campaign;
            }
        }
        return $foundCampaigns;
    }


    public function get_ALLCampaignsByCompany(Company $company)
    {
        $foundCampaigns = [];
        $foundAllCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($foundAllCampaigns as $campaign){
            /**
             * @var Campaign $campaign
             */
            if((!$campaign->getisDeleted()) && ($campaign->getCompany()->getId() == $company->getId())){
                $foundCampaigns[] = $campaign;
            }
        }
        return $foundCampaigns;
    }

    public function getALLCampaigns()
    {
        $foundCampaigns = [];
        $foundAllCampaigns = $this->EntityManager->getRepository(Campaign::class)->findAll();
        foreach ($foundAllCampaigns as $campaign){
            /**
             * @var Campaign $campaign
             */
            if((!$campaign->getisDeleted())){
                $foundCampaign[] = $campaign->getArray();
            }
        }
        return $foundCampaigns;
    }

    public function removeCampaign(Campaign $campaign)
    {
        if($campaign->getId()){
            /**
             * @var Campaign $foundCampaign
             */
            $foundCampaign= $this->getCampaign($campaign);
            if($foundCampaign){
                $this->EntityManager->remove($foundCampaign);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addNewSendMessage(SendMessage $sendMessage)
    {
        $sendMessage->setId(null);
        $sendMessage->setIsActive(1);
        $sendMessage->setIsDeleted(0);
        $sendMessage->setCreatedDate(new \DateTime('now'));
        $sendMessage->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($sendMessage);
        $this->EntityManager->flush();
        if($sendMessage->getId()){
            return $sendMessage;
        }else{
            return null;
        }
    }

    public function updateSendMessage(SendMessage $sendMessage)
    {
        if($sendMessage){
            $this->EntityManager->persist($sendMessage);
            $this->EntityManager->flush();
            if($sendMessage->getId()){
                return $sendMessage;
            }
        }
        return null;
    }

    public function getSendMessage(SendMessage $sendMessage)
    {
        if($sendMessage->getId()){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->find($sendMessage->getId());
            return $foundSendMessage;
        }else{
            return null;
        }
    }

    public function getNotDeliveredSendMessagesByCampaignID(Campaign $campaign)
    {
        $foundMessage = [];
        if($campaign){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
            foreach ($foundSendMessage as $messages){
                /**
                 * @var SendMessage $messages
                 */
                if(($messages->getCampaign()->getId() == $campaign->getId()) && (!$messages->getisDelivered()) && ($messages->getisActive())){
                    $foundMessage[] = $messages->getArray();
                }
            }
        }
        return $foundMessage;
    }

    public function getNotDeliveredSendMessagesByCampaignIDs($campaigns)
    {
        $foundMessage = [];
        if(count($campaigns)>0){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
            foreach ($foundSendMessage as $messages){
                /**
                 * @var SendMessage $messages
                 */
                foreach ($campaigns as $campaign){
                    /**
                     * @var Campaign $campaign
                     */
                    if(($messages->getCampaign()->getId() == $campaign->getId()) && (!$messages->getisDelivered()) && ($messages->getisActive())){
                        $foundMessage[] = $messages->getArray();
                    }
                }
            }
        }
        return $foundMessage;
    }

    public function getALLSendMessageByCompany(Company $company)
    {
        $foundMessage = [];
        $campaigns = $this->get_ALLCampaignsByCompany($company);
        if($campaigns){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
            foreach ($foundSendMessage as $messages){
                /**
                 * @var SendMessage $messages
                 */
                if(in_array($messages->getCampaign(),$campaigns)){
                    $foundMessage[] = $messages->getArray();
                }
            }
        }
        return $foundMessage;
    }

    public function getSendMessagesByCampaign(Campaign $campaign)
    {
        $foundMessage = [];
        if($campaign){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
            foreach ($foundSendMessage as $messages){
                /**
                 * @var SendMessage $messages
                 */
                if($messages->getCampaign()->getId() == $campaign->getId()){
                    $foundMessage[] = $messages->getArray();
                }
            }
        }
        return $foundMessage;
    }

    public function getSendMessagesOfUser(User $user)
    {
        $foundMessage = [];
        if($user){
            $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
            foreach ($foundSendMessage as $messages){
                /**
                 * @var SendMessage $messages
                 */
                if($user->getPrivilege()->getId()<3){
                    $companyUser = $this->getCompanyUserByUser($user);
                    if($companyUser && $companyUser->getCompany()->getId() == $messages->getCampaign()->getCompany()->getId()){
                        $foundMessage[] = $messages->getArray();
                    }
                }elseif ($this->getCampaignUserByCampaignAndUser($messages->getCampaign(),$user)){
                    $foundMessage[] = $messages->getArray();
                }
            }
        }
        return $foundMessage;
    }

    public function getALLSendMessages()
    {
        $foundMessage = [];
        $foundSendMessage= $this->EntityManager->getRepository(SendMessage::class)->findAll();
        foreach ($foundSendMessage as $messages){
            /**
             * @var SendMessage $messages
             */
            $foundMessage[] = $messages->getArray();
        }
        return $foundMessage;
    }

    public function removeSendMessage(SendMessage $sendMessage)
    {
        if($sendMessage->getId()){
            /**
             * @var SendMessage $foundSendMessage
             */
            $foundSendMessage = $this->getSendMessage($sendMessage);
            if($foundSendMessage){
                $this->EntityManager->remove($foundSendMessage);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addNewReceivedMessage(ReceivedMessage $receivedMessage)
    {
        $receivedMessage->setId(null);
        $receivedMessage->setIsActive(1);
        $receivedMessage->setIsDeleted(0);
        $receivedMessage->setCreatedDate(new \DateTime('now'));
        $receivedMessage->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($receivedMessage);
        $this->EntityManager->flush();
        if($receivedMessage->getId()){
            return $receivedMessage;
        }else{
            return null;
        }
    }

    public function getReceivedMessage(ReceivedMessage $receivedMessage)
    {
        if($receivedMessage->getId()){
            $foundReceivedMessage= $this->EntityManager->getRepository(ReceivedMessage::class)->find($receivedMessage->getId());
            return $foundReceivedMessage;
        }else{
            return null;
        }
    }

    public function getReceivedMessagesByCompany(Company $company)
    {
        $foundMessage = [];
        if($company->getId()){
            $foundReceivedMessage= $this->EntityManager->getRepository(ReceivedMessage::class)->findAll();
            foreach ($foundReceivedMessage as $messages){
                /**
                 * @var ReceivedMessage $messages
                 */
                if($messages->getSMSPort()->getCompany()->getId() == $company->getId()){
                    $foundMessage[] = $messages->getArray();
                }
            }
        }
        return $foundMessage;
    }

    public function getReceivedMessagesByCampaign(Campaign $campaign)
    {
        $foundMessage = [];
        if($campaign->getId()){
            $foundReceivedMessage= $this->EntityManager->getRepository(ReceivedMessage::class)->findAll();
            foreach ($foundReceivedMessage as $messages){
                /**
                 * @var ReceivedMessage $messages
                 */

            }
        }
        return $foundMessage;
    }

    public function removeReceivedMessage(ReceivedMessage $receivedMessage)
    {
        if($receivedMessage->getId()){
            /**
             * @var ReceivedMessage $foundReceivedMessage
             */
            $foundReceivedMessage = $this->getReceivedMessage($receivedMessage);
            if($foundReceivedMessage){
                $this->EntityManager->remove($foundReceivedMessage);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addCampaignUser(CampaignUser $campaignUser)
    {
        $campaignUser->setId(null);
        $campaignUser->setIsActive(1);
        $campaignUser->setIsDeleted(0);
        $campaignUser->setCreatedDate(new \DateTime('now'));
        $campaignUser->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($campaignUser);
        $this->EntityManager->flush();
        if($campaignUser->getId()){
            return $campaignUser;
        }else{
            return null;
        }
    }

    public function getCampaignUser(CampaignUser $campaignUser)
    {
        if($campaignUser->getId()){
            $foundCampaignUser = $this->EntityManager->getRepository(CampaignUser::class)->find($campaignUser->getId());
            return $foundCampaignUser;
        }else{
            return null;
        }
    }

    public function getCampaignUserByCampaignAndUser(Campaign $campaign, User $user)
    {
        if($campaign->getId() && $user->getId()){
            $foundCampaignUsers = $this->EntityManager->getRepository(CampaignUser::class)->findAll();
            foreach ($foundCampaignUsers as $campaign_User){
                /**
                 * @var CampaignUser $campaign_User
                 */
                if($campaign_User->getCampaign()->getId() == $campaign->getId() && $campaign_User->getUser()->getId() == $user->getId()){
                    return $campaign_User;
                }
            }
        }
        return null;
    }

    public function getCampaignUsersByCompany(Company $company)
    {
        $CampaignUsers = [];
        if($company->getId()){
            $foundCampaignUsers = $this->EntityManager->getRepository(CampaignUser::class)->findAll();
            foreach ($foundCampaignUsers as $campaign_User){
                /**
                 * @var CampaignUser $campaign_User
                 */
                if($campaign_User->getCampaign()->getCompany()->getId() == $company->getId()){
                    $CampaignUsers[] = $campaign_User->getArray();
                }
            }
        }
        return $CampaignUsers;
    }

    public function getCampaignUsersByCampaign(Campaign $campaign)
    {
        $CampaignUsers = [];
        if($campaign->getId()){
            $foundCampaignUsers = $this->EntityManager->getRepository(CampaignUser::class)->findAll();
            foreach ($foundCampaignUsers as $campaign_User){
                /**
                 * @var CampaignUser $campaign_User
                 */
                if($campaign_User->getCampaign()->getId() == $campaign->getId()){
                    $CampaignUsers[] = $campaign_User->getUser()->getArray();
                }
            }
        }
        return $CampaignUsers;
    }

    public function getCampaignsByCompanyAndUser(Company $company, User $user)
    {
        $Campaigns = [];
        if($company->getId() && $user->getId()){
            $foundCampaignUsers = $this->EntityManager->getRepository(CampaignUser::class)->findAll();
            foreach ($foundCampaignUsers as $campaign_User){
                /**
                 * @var CampaignUser $campaign_User
                 */
                if($campaign_User->getCampaign()->getCompany()->getId() == $company->getId() && $campaign_User->getUser()->getId() == $user->getId()){
                    $Campaigns[] = $campaign_User->getCampaign()->getArray();
                }
            }
        }
        return $Campaigns;
    }

    public function removeCampaignUser(CampaignUser $campaignUser)
    {
        if($campaignUser->getId()){
            /**
             * @var CampaignUser $foundCampaignUser
             */
            $foundCampaignUser = $this->getCampaignUser($campaignUser);
            if($foundCampaignUser){
                $this->EntityManager->remove($foundCampaignUser);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function removeCampaignUserByCampaign(Campaign $campaign)
    {
        $state = false;
        if($campaign->getId()){
            $foundCampaignUsers = $this->EntityManager->getRepository(CampaignUser::class)->findAll();
            foreach ($foundCampaignUsers as $campaign_User){
                /**
                 * @var CampaignUser $campaign_User
                 */
                if($campaign_User->getCampaign()->getId() == $campaign->getId()){
                    if($this->removeCampaignUser($campaign_User)){
                        $state = true;
                    }
                }
            }
        }
        return $state;
    }

    public function addContact(Contact $contact)
    {
        $contact->setId(null);
        $contact->setIsActive(1);
        $contact->setIsDeleted(0);
        $contact->setCreatedDate(new \DateTime('now'));
        $contact->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($contact);
        $this->EntityManager->flush();
        if($contact->getId()){
            return $contact;
        }else{
            return null;
        }
    }

    public function getContact(Contact $contact)
    {
        if($contact->getId()){
            $foundContact = $this->EntityManager->getRepository(Contact::class)->find($contact->getId());
            return $foundContact;
        }else{
            return null;
        }
    }

    public function getContactsByCampany(Company $company)
    {
        $Contacts = [];
        if($company->getId()){
            $foundContacts = $this->EntityManager->getRepository(Contact::class)->findAll();
            foreach ($foundContacts as $contact){
                /**
                 * @var Contact $contact
                 */
                if($contact->getCompany()->getId() == $company->getId()){
                    $Contacts[] = $contact->getArray();
                }
            }
        }
        return $Contacts;
    }

    public function removeContact(Contact $contact)
    {
        if($contact->getId()){
            $foundContact = $this->getContact($contact);
            if($foundContact){
                $this->EntityManager->remove($foundContact);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function removeContactByCompany(Contact $contact)
    {
        if($contact->getId()){
            /**
             * @var Contact $foundContact
             */
            $foundContact = $this->getContact($contact);
            if($foundContact && $foundContact->getCompany()->getId() == $contact->getCompany()->getId()){
                $this->EntityManager->remove($foundContact);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addGroup(Group $group)
    {
        $group->setId(null);
        $group->setIsActive(1);
        $group->setIsDeleted(0);
        $group->setCreatedDate(new \DateTime('now'));
        $group->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($group);
        $this->EntityManager->flush();
        if($group->getId()){
            return $group;
        }else{
            return null;
        }
    }

    public function getGroup(Group $group)
    {
        if($group->getId()){
            $foundGroup = $this->EntityManager->getRepository(Group::class)->find($group->getId());
            return $foundGroup;
        }else{
            return null;
        }
    }

    public function getGroupsByCampany(Company $company)
    {
        $Groups = [];
        if($company->getId()){
            $foundGroups = $this->EntityManager->getRepository(Group::class)->findAll();
            foreach ($foundGroups as $group){
                /**
                 * @var Group $group
                 */
                if($group->getCompany()->getId() == $company->getId()){
                    $Groups[] = $group->getArray();
                }
            }
        }
        return $Groups;
    }

    public function removeGroup(Group $group)
    {
        if($group->getId()){
            $foundGroup = $this->getGroup($group);
            if($foundGroup){
                $this->EntityManager->remove($foundGroup);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addGroupedContact(GroupedContact $groupedContact)
    {
        $groupedContact->setId(null);
        $groupedContact->setIsActive(1);
        $groupedContact->setIsDeleted(0);
        $groupedContact->setCreatedDate(new \DateTime('now'));
        $groupedContact->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($groupedContact);
        $this->EntityManager->flush();
        if($groupedContact->getId()){
            return $groupedContact;
        }else{
            return null;
        }
    }

    public function getGroupedContact(GroupedContact $groupedContact)
    {
        if($groupedContact->getId()){
            $foundGroupedContact = $this->EntityManager->getRepository(GroupedContact::class)->find($groupedContact->getId());
            return $foundGroupedContact;
        }else{
            return null;
        }
    }

    public function getGroupedContactsByCampany(Company $company)
    {
        $GroupedContacts = [];
        if($company->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getCompany()->getId() == $company->getId()){
                    $GroupedContacts[] = $groupedContact->getArray();
                }
            }
        }
        return $GroupedContacts;
    }

    public function getGroupedContactsByGroup(Group $group)
    {
        $GroupedContacts = [];
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId()){
                    $GroupedContacts[] = $groupedContact->getArray();
                }
            }
        }
        return $GroupedContacts;
    }

    public function getGroupedContactByGroupAndContact(Group $group, Contact $contact)
    {
        if($group->getId() && $contact->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId() && $groupedContact->getContact()->getId() == $contact->getId()){
                    return $groupedContact;
                }
            }
        }
        return null;
    }

    public function getContactsNotInGroup(Group $group)
    {
        $Contacts = [];
        if($group->getId()){
            $foundContacts = $this->EntityManager->getRepository(Contact::class)->findAll();
            foreach ($foundContacts as $contact){
                /**
                 * @var Contact $contact
                 */
                if(!$this->getGroupedContactByGroupAndContact($group,$contact) && $group->getCompany()->getId() == $contact->getCompany()->getId()){
                    $Contacts[] = $contact->getArray();
                }
            }
        }
        return $Contacts;
    }

    public function getGroupedContactsNotInGroup(Group $group)
    {
        $Contacts = [];
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if(!$this->getGroupedContactByGroupAndContact($group,$groupedContact->getContact()) && $group->getCompany()->getId() == $groupedContact->getCompany()->getId()){
                    $Contacts[] = $groupedContact->getArray();
                }
            }
        }
        return $Contacts;
    }


    public function getContactsInGroup(Group $group)
    {
        $Contacts = [];
        if($group->getId()){
            $foundContacts = $this->EntityManager->getRepository(Contact::class)->findAll();
            foreach ($foundContacts as $contact){
                /**
                 * @var Contact $contact
                 */
                if($this->getGroupedContactByGroupAndContact($group,$contact)){
                    $Contacts[] = $contact->getArray();
                }
            }
        }
        return $Contacts;
    }

    public function getGroupedContactsInGroup(Group $group)
    {
        $Contacts = [];
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId()){
                    $Contacts[] = $groupedContact->getArray();
                }
            }
        }
        return $Contacts;
    }


    public function getContactsByGroup(Group $group)
    {
        $GroupedContacts = [];
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId()){
                    $GroupedContacts[] = $groupedContact->getContact()->getArray();
                }
            }
        }
        return $GroupedContacts;
    }

    public function listGroupedContactsByGroup(Group $group)
    {
        $GroupedContacts = [];
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId()){
                    $GroupedContacts[] = $groupedContact;
                }
            }
        }
        return $GroupedContacts;
    }

    public function removeGroupedContact(GroupedContact $groupedContact)
    {
        if($groupedContact->getId()){
            $foundGroupedContact = $this->getGroupedContact($groupedContact);
            if($foundGroupedContact){
                $this->EntityManager->remove($foundGroupedContact);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function removeGroupedContactByGroup(Group $group)
    {
        $state = false;
        if($group->getId()){
            $foundGroupedContacts = $this->EntityManager->getRepository(GroupedContact::class)->findAll();
            foreach ($foundGroupedContacts as $groupedContact){
                /**
                 * @var GroupedContact $groupedContact
                 */
                if($groupedContact->getGroup()->getId() == $group->getId()){
                    if($this->removeGroupedContact($groupedContact)){
                        $state = true;
                    }
                }
            }
        }
        return $state;
    }


    public function addGroupMessage(GroupMessage $groupMessage)
    {
        $groupMessage->setId(null);
        $groupMessage->setIsActive(1);
        $groupMessage->setIsDeleted(0);
        $groupMessage->setCreatedDate(new \DateTime('now'));
        $groupMessage->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($groupMessage);
        $this->EntityManager->flush();
        if($groupMessage->getId()){
            return $groupMessage;
        }else{
            return null;
        }
    }

    public function getGroupMessage(GroupMessage $groupMessage)
    {
        if($groupMessage->getId()){
            $foundGroupMessage = $this->EntityManager->getRepository(GroupMessage::class)->find($groupMessage->getId());
            return $foundGroupMessage;
        }else{
            return null;
        }
    }

    public function getGroupMessagesByCompany(Company $company)
    {
        $GroupedMessages = [];
        if($company->getId()){
            $foundGroupMessages= $this->EntityManager->getRepository(GroupMessage::class)->findAll();
            foreach ($foundGroupMessages as $groupMessage){
                /**
                 * @var GroupMessage $groupMessage
                 */
                if($groupMessage->getGroup()->getCompany()->getId() == $company->getId()){
                    $GroupedMessages[] = $groupMessage->getArray();
                }
            }
        }
        return $GroupedMessages;
    }

    public function getGroupMessagesByGroup(Group $group)
    {
        $GroupedMessages = [];
        if($group->getId()){
            $foundGroupMessages= $this->EntityManager->getRepository(GroupMessage::class)->findAll();
            foreach ($foundGroupMessages as $groupMessage){
                /**
                 * @var GroupMessage $groupMessage
                 */
                if($groupMessage->getGroup()->getId() == $group->getId()){
                    $GroupedMessages[] = $groupMessage->getArray();
                }
            }
        }
        return $GroupedMessages;
    }

    public function getGroupMessagesOfUser(User $user)
    {
        $GroupedMessages = [];
        if($user->getId()){
            $foundGroupMessages= $this->EntityManager->getRepository(GroupMessage::class)->findAll();
            foreach ($foundGroupMessages as $groupMessage){
                /**
                 * @var GroupMessage $groupMessage
                 */
                if($user->getPrivilege()->getId()<3){
                    $companyUser = $this->getCompanyUserByUser($user);
                    if($companyUser && $companyUser->getCompany()->getId() == $groupMessage->getCampaign()->getCompany()->getId()){
                        $GroupedMessages[] = $groupMessage->getArray();
                    }
                }elseif ($this->getCampaignUserByCampaignAndUser($groupMessage->getCampaign(),$user)){
                    $GroupedMessages[] = $groupMessage->getArray();
                }
            }
        }
        return $GroupedMessages;
    }

    public function removeGroupMessage(GroupMessage $groupMessage)
    {
        if($groupMessage->getId()){
            $foundGroupMessage = $this->getGroupMessage($groupMessage);
            if($foundGroupMessage){
                $this->EntityManager->remove($foundGroupMessage);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addForgotPassword(ForgotPassword $forgotPassword)
    {
        $forgotPassword->setId(null);
        $forgotPassword->setIsActive(1);
        $forgotPassword->setIsDeleted(0);
        $forgotPassword->setCreatedDate(new \DateTime('now'));
        $forgotPassword->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($forgotPassword);
        $this->EntityManager->flush();
        if($forgotPassword->getId()){
            return $forgotPassword;
        }else{
            return null;
        }
    }

    public function getForgotPassword(ForgotPassword $forgotPassword)
    {
        if($forgotPassword->getId()){
            $foundForgotPassword = $this->EntityManager->getRepository(ForgotPassword::class)->find($forgotPassword->getId());
            return $foundForgotPassword;
        }else{
            return null;
        }
    }

    public function getForgotPasswordByUser(User $user)
    {
        $foundForgotPassword = null;
        if($user->getId()){
            $foundForgotPasswords= $this->EntityManager->getRepository(ForgotPassword::class)->findAll();
            foreach ($foundForgotPasswords as $forgotPassword){
                /**
                 * @var ForgotPassword $forgotPassword
                 */
                if($forgotPassword->getUser()->getId() == $user->getId()){
                    $foundForgotPassword = $forgotPassword;
                }
            }
        }
        return $foundForgotPassword;
    }

    public function getForgotPasswordByResetCodeAndUserEmail(ForgotPassword $forgotPassword)
    {
        $foundForgotPassword = null;
        if($forgotPassword->getResetCode() && $forgotPassword->getUser() && $forgotPassword->getUser()->getEmail()){
            $foundForgotPasswords= $this->EntityManager->getRepository(ForgotPassword::class)->findAll();
            foreach ($foundForgotPasswords as $_forgotPassword){
                /**
                 * @var ForgotPassword $_forgotPassword
                 */
                if($_forgotPassword->getResetCode() == $forgotPassword->getResetCode() && $_forgotPassword->getUser()->getEmail() == $forgotPassword->getUser()->getEmail()){
                    $foundForgotPassword = $_forgotPassword;
                }
            }
        }
        return $foundForgotPassword;
    }

    public function getActiveForgotPasswordByUser(User $user)
    {
        $foundForgotPassword = null;
        if($user->getId()){
            $foundForgotPasswords= $this->EntityManager->getRepository(ForgotPassword::class)->findAll();
            foreach ($foundForgotPasswords as $forgotPassword){
                /**
                 * @var ForgotPassword $forgotPassword
                 */
                if($forgotPassword->getUser()->getId() == $user->getId() && $forgotPassword->getisActive()){
                    $foundForgotPassword = $forgotPassword;
                }
            }
        }
        return $foundForgotPassword;
    }

    public function removeForgotPassword(ForgotPassword $forgotPassword)
    {
        if($forgotPassword->getId()){
            $foundForgotPassword = $this->getForgotPassword($forgotPassword);
            if($foundForgotPassword){
                $this->EntityManager->remove($foundForgotPassword);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function removeForgotPasswordsByUser(User $user)
    {
        $state = false;
        if($user->getId()){
            $foundForgotPasswords= $this->EntityManager->getRepository(ForgotPassword::class)->findAll();
            foreach ($foundForgotPasswords as $forgotPassword){
                /**
                 * @var ForgotPassword $forgotPassword
                 */
                if($forgotPassword->getUser()->getId() == $user->getId()){
                    if($this->removeForgotPassword($forgotPassword)){
                        $state = true;
                    }
                }
            }
        }
        return $state;
    }

    public function updateForgotPassword(ForgotPassword $forgotPassword)
    {
        if($forgotPassword){
            $this->EntityManager->persist($forgotPassword);
            $this->EntityManager->flush();
            if($forgotPassword->getId()){
                return $forgotPassword;
            }
        }
        return null;
    }


}