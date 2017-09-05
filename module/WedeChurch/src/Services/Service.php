<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:24 PM
 */

namespace WedeChurch\Services;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use WedeChurch\Entities\Church;
use WedeChurch\Entities\Event;
use WedeChurch\Entities\Event_category;
use WedeChurch\Entities\Privilege;
use WedeChurch\Entities\User;

class Service implements ServicesMethods
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
            try {
                $foundUser = $this->EntityManager->getRepository(User::class)->find($user->getId());
            }catch (EntityNotFoundException $exception){

                print $exception;
            }

            return $foundUser;
        }else{
            return null;
        }
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
        return null;
    }

    public function updateUser(User $user)
    {
        if($user->getId()){
            $this->EntityManager->persist($user);
            $this->EntityManager->flush();
            if($user->getId()){
                return $user;
            }else{
                return null;
            }
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

    public function addChurch(Church $church)
    {
        $church->setId(null);
        $church->setIsActive(1);
        $church->setIsDeleted(0);
        $church->setCreatedDate(new \DateTime('now'));
        $church->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($church);
        $this->EntityManager->flush();
        if($church->getId()){
            return $church;
        }else{
            return null;
              }
    }

    public function getChurch(Church $church)
    {
        $AllfoundChurch = $this->EntityManager->getRepository(Church::class)->findAll();
        foreach ($AllfoundChurch as $_church){
            /**
             * @var Church $_church
             */
            if($church->getId() == $_church->getId()){
                $foundChurch  = $_church->getArray();
                return $foundChurch;
            }
        }
        return null;
    }

    public function getAllChurch()
    {
        $foundChurches = [];
        $allChurches = $this->EntityManager->getRepository(Church::class)->findAll();
        foreach ($allChurches as $church){
            $foundChurches[] = $church->getArray();
        }
        return $foundChurches;
    }

    public function updateChurch(Church $church)
    {
        if($church->getId()){
            $this->EntityManager->persist($church);
            $this->EntityManager->flush();
            if($church->getId()){
                return $church;
            }else{
                return null;
            }
        }
    }

    public function removeChurch(Church $church)
    {
        if($church){
            /**
             * @var church $foundChurch
             */
            $foundChurch = $this->getChurch($church);
            if($foundChurch){
                $this->EntityManager->remove($foundChurch);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addEvent(Event $event)
    {
        $event->setId(null);
        $event->setIsActive(1);
        $event->setIsDeleted(0);
        $event->setCreatedDate(new \DateTime('now'));
        $event->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($event);
        $this->EntityManager->flush();
        if($event->getId()){
            return $event;
        }else{
            return null;
        }
    }

    public function getEvent(Event $event)
    {

        $AllfoundEvent = $this->EntityManager->getRepository(Event::class)->findAll();
        foreach ($AllfoundEvent as $_event){
            /**
             * @var Event $_event
             */
            if($event->getId() == $_event->getId()){
                $foundEvent  = $_event->getArray();
                return $foundEvent;
            }
        }
        return null;

    }

    public function getAllEvent()
    {
        $foundEvents = [];
        $AllfoundEvent = $this->EntityManager->getRepository(Event::class)->findAll();
        foreach ($AllfoundEvent as $event){

            $foundEvents[] = $event->getArray();
        }
        return $foundEvents;
    }

    public function updateEvent(Event $event)
    {
        if($event->getId()) {
            $this->EntityManager->persist($event);
            $this->EntityManager->flush();
            if ($event->getId()) {
                return $event;
            } else {
                return null;
            }
        }
    }

    public function removeEvent(Event $event)
    {
        if($event){
            /**
             * @var Event $foundEvent
             */
            $foundEvent = $this->getEvent($event);
            if($foundEvent){
                $this->EntityManager->remove($foundEvent);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function addEvent_Category(Event_category $event_category)
    {
        $event_category->setId(null);
        $event_category->setIsActive(1);
        $event_category->setIsDeleted(0);
        $event_category->setCreatedDate(new \DateTime('now'));
        $event_category->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($event_category);
        $this->EntityManager->flush();
        if($event_category->getId()){
            return $event_category;
        }else{
            return null;
        }
    }

    public function getEvent_Category(Event_category $event_category)
    {
        if($event_category->getId()){
            $foundEvent_category = $this->EntityManager->getRepository(Event_category::class)->find($event_category->getId());
            return  $foundEvent_category;
        }else{
            return null;
        }
    }

    public function getAllEvent_Category()
    {
        $foundEvent_category = [];
        $allEvent_category = $this->EntityManager->getRepository(Event_category::class)->findAll();
        foreach ($allEvent_category as $event_category){

            $foundEvent_category[] = $event_category->getArray();
        }
        return  $foundEvent_category;
    }

    public function updateEvent_Category(Event_category $event_category)
    {
        if($event_category->getId()){
            $this->EntityManager->persist($event_category);
            $this->EntityManager->flush();
            if($event_category->getId()){
                return $event_category;
            }else{
                return null;
            }
        }
    }

    public function removeEvent_Category(Event_category $event_category)
    {
        if($event_category){
            /**
             * @var Event_category $foundEvent_category
             */
            $foundEvent_category = $this->getEvent_Category($event_category);
            if( $foundEvent_category){
                $this->EntityManager->remove( $foundEvent_category);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;

    }


}


