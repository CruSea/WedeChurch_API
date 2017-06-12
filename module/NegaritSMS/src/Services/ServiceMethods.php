<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:34 AM
 */

namespace NegaritSMS\Services;


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

interface ServiceMethods
{
    /**
     * User Table
     * @return mixed
     */
    public function getDashboard(Company $company);
    public function getLastSentMessages(Company $company);
    public function getSMSCampaignStatus(Company $company);


    /**
     * User Table
     * @return mixed
     */
    public function addUser(User $user);
    public function getUser(User $user);
    public function getUserByEmail(User $user);
    public function getUserByID(User $user);
    public function checkUser(User $user);
    public function updateUser(User $user);
    public function removeUser(User $user);

    /**
     * Company Table
     * @return mixed
     */
    public function addCompany(Company $company);
    public function activateCompany(Company $company);
    public function deActivateCompany(Company $company);
    public function getCompany(Company $company);
    public function getAllCompanies();
    public function getAllActiveCompanies();
    public function getAllNotActiveCompanies();
    public function removeCompany(Company $company);

    /**
     * Company Table
     * @return mixed
     */
    public function addCompanyUser(CompanyUser $companyUser);
    public function getCompanyUserByID(CompanyUser $companyUser);
    public function getCompanyUserByUser(User $user);
    public function getUsersByCompany(Company $company);
    public function removeCompanyUser(CompanyUser $companyUser);
    public function removeCompanyUserByUser(User $user);
    public function removeCompanyUsersByCompany(Company $company);

    /**
     * Company Privilege
     * @return mixed
     */
    public function addPrivilege(Privilege $privilege);
    public function getPrivilege(Privilege $privilege);
    public function getAllPrivilege();
    public function getLessPrivilege(Privilege $privilege);

    /**
     * SMS PORTS
     * @return mixed
     */
    public function addSMSPort(SMSPort $port);
    public function getSMSPort(SMSPort $port);
    public function getSMSPortByCompanyAndName(Company $company, SMSPort $port);
    public function getSMSPortByDeviceIDAndSecret(SMSPort $SMSPort);
    public function getAllSMSPortsByCompany(Company $company);
    public function getActiveSMSPortsByCompany(Company $company);
    public function getAllSMSPorts();
    public function listAllSMSPorts();
    public function removeSMSPorts(SMSPort $SMSPort);

    /**
     * Campaign Table
     * @return mixed
     */
    public function addNewCampaign(Campaign $campaign);
    public function getCampaign(Campaign $campaign);
    public function getCampaignByCompanyAndName(Company $company, Campaign $campaign);
    public function getALLCampaignsByCompany(Company $company);
    public function listCampaignsBySMSPort(SMSPort $SMSPort);
    public function getALLCampaigns();
    public function removeCampaign(Campaign $campaign);

    /**
     * Send Message Table
     * @return mixed
     */
    public function addNewSendMessage(SendMessage $sendMessage);
    public function getSendMessage(SendMessage $sendMessage);
    public function updateSendMessage(SendMessage $sendMessage);
    public function getALLSendMessageByCompany(Company $company);
    public function getSendMessagesByCampaign(Campaign $campaign);
    public function getSendMessagesOfUser(User $user);
    public function getALLSendMessages();
    public function removeSendMessage(SendMessage $sendMessage);

    public function getNotDeliveredSendMessagesByCampaignID(Campaign $campaign);
    public function getNotDeliveredSendMessagesByCampaignIDs($campaigns);

    /**
     * Received Message Table
     * @return mixed
     */
    public function addNewReceivedMessage(ReceivedMessage $receivedMessage);
    public function getReceivedMessage(ReceivedMessage $receivedMessage);
    public function getReceivedMessagesByCompany(Company $company);
    public function getReceivedMessagesByCampaign(Campaign $campaign);
    public function removeReceivedMessage(ReceivedMessage $receivedMessage);

    /**
     * Campaign User Table
     * @return mixed
     */
    public function addCampaignUser(CampaignUser $campaignUser);
    public function getCampaignUser(CampaignUser $campaignUser);
    public function getCampaignUserByCampaignAndUser(Campaign $campaign, User $user);
    public function getCampaignUsersByCompany(Company $company);
    public function getCampaignUsersByCampaign(Campaign $campaign);
    public function getCampaignsByCompanyAndUser(Company $company, User $user);
    public function removeCampaignUser(CampaignUser $campaignUser);
    public function removeCampaignUserByCampaign(Campaign $campaign);

    /**
     * Company Contact Table
     * @return mixed
     */
    public function addContact(Contact $contact);
    public function getContact(Contact $contact);
    public function getContactsByCampany(Company $company);
    public function removeContact(Contact $contact);
    public function removeContactByCompany(Contact $contact);

    /**
     * Company Group Table
     * @return mixed
     */
    public function addGroup(Group $group);
    public function getGroup(Group $group);
    public function getGroupsByCampany(Company $company);
    public function removeGroup(Group $group);

    /**
     * Company Grouped Contact Table
     * @return mixed
     */
    public function addGroupedContact(GroupedContact $groupedContact);
    public function getGroupedContact(GroupedContact $groupedContact);
    public function getGroupedContactsByCampany(Company $company);
    public function getGroupedContactsByGroup(Group $group);
    public function getGroupedContactByGroupAndContact(Group $group, Contact $contact);
    public function getContactsByGroup(Group $group);
    public function getContactsNotInGroup(Group $group);
    public function getGroupedContactsNotInGroup(Group $group);
    public function getContactsInGroup(Group $group);
    public function getGroupedContactsInGroup(Group $group);
    public function listGroupedContactsByGroup(Group $group);
    public function removeGroupedContact(GroupedContact $groupedContact);
    public function removeGroupedContactByGroup(Group $group);

    /**
     * Company Group Message Table
     * @return mixed
     */
    public function addGroupMessage(GroupMessage $groupMessage);
    public function getGroupMessage(GroupMessage $groupMessage);
    public function getGroupMessagesByCompany(Company $company);
    public function getGroupMessagesByGroup(Group $group);
    public function getGroupMessagesOfUser(User $user);
    public function removeGroupMessage(GroupMessage $groupMessage);

    /**
     * Company Forgot Password Table
     * @return mixed
     */
    public function addForgotPassword(ForgotPassword $forgotPassword);
    public function getForgotPassword(ForgotPassword $forgotPassword);
    public function getForgotPasswordByResetCodeAndUserEmail(ForgotPassword $forgotPassword);
    public function getForgotPasswordByUser(User $user);
    public function getActiveForgotPasswordByUser(User $user);
    public function removeForgotPassword(ForgotPassword $forgotPassword);
    public function removeForgotPasswordsByUser(User $user);
    public function updateForgotPassword(ForgotPassword $forgotPassword);

}