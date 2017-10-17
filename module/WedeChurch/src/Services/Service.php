<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:24 PM
 */

namespace WedeChurch\Services;


use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;
use WedeChurch\Entities\Church;
use WedeChurch\Entities\Event;
use WedeChurch\Entities\Event_category;
use WedeChurch\Entities\Favorite;
use WedeChurch\Entities\Privilege;
use WedeChurch\Entities\Schedule;
use WedeChurch\Entities\Schedule_category;
use WedeChurch\Entities\User;
use WedeChurch\Entities\Denomination;

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
        try {
            $this->EntityManager->persist($user);
            $this->EntityManager->flush();
        }catch (\Exception $exception
            ){
            print $exception;
        }

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
            }catch (\Exception $exception){

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
        print_r('');
        try {
            $this->EntityManager->persist($church);
            $this->EntityManager->flush($church);
        }
        catch (\Exception $exception){
                print $exception;
            }


        if($church->getId()){
            return $church;
        }else{
            return null;
              }
    }

    public function getChurch(Church $church)
    {
        try {
            $AllfoundChurch = $this->EntityManager->getRepository(Church::class)->findAll();
        }catch (\Exception $exception)
        {
            print $exception;
        }
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
        try {
            $allChurches = $this->EntityManager->getRepository(Church::class)->findAll();
        }catch (\Exception $exception){
            print $exception;
        }
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
                $foundEvent  = $_event;
                return $foundEvent;
            }
        }
        return null;

    }

    public function getAllEvent()
    {
        $foundEvents = [];
        try {
            $AllfoundEvent = $this->EntityManager->getRepository(Event::class)->findAll();
        }catch (\Exception $exception){
            print $exception ;
        }
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




    //schedule category

    public function addSchedule_category(Schedule_category $schedule_category)
    {
        $schedule_category->setId(null);
        $schedule_category->setIsActive(1);
        $schedule_category->setIsDeleted(0);
        $schedule_category->setCreatedDate(new \DateTime('now'));
        $schedule_category->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($schedule_category);
        $this->EntityManager->flush();
        if($schedule_category->getId()){
            return $schedule_category;
        }else{
            return null;
        }
    }

    public function getSchedule_category(Schedule_category $schedule_category)
    {
        if($schedule_category->getId()){
            $foundSchedule_category = $this->EntityManager->getRepository(Schedule_category::class)->find($schedule_category->getId());
            return  $foundSchedule_category;
        }else{
            return null;
        }
    }

    public function getAllSchedule_category()
    {
        $foundSchedule_category = [];
        $allSchedule_category = $this->EntityManager->getRepository(Schedule_category::class)->findAll();
        foreach ($allSchedule_category as $schedule_category){

            $foundSchedule_category[] = $schedule_category->getArray();
        }
        return  $foundSchedule_category;
    }

    public function updateSchedule_category(Schedule_category $schedule_category)
    {
        if( $schedule_category->getId()){
            $this->EntityManager->persist($schedule_category);
            $this->EntityManager->flush();
            if( $schedule_category->getId()){
                return  $schedule_category;
            }else{
                return null;
            }
        }
    }

    public function removeSchedule_category(Schedule_category $schedule_category)
    {
        if($schedule_category){
            /**
             * @var $schedule_category  $foundSchedule_category
             */
            $foundSchedule_category = $this->getSchedule_category($schedule_category);
            if( $foundSchedule_category){
                $this->EntityManager->remove( $foundSchedule_category);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }


    //  //schedule

    public function addSchedule(Schedule $schedule)
    {
        $schedule->setId(null);
        $schedule->setIsActive(1);
        $schedule->setIsDeleted(0);
        $schedule->setCreatedDate(new \DateTime('now'));
        $schedule->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($schedule);
        $this->EntityManager->flush();
        if($schedule->getId()){
            return $schedule;
        }else{
            return null;
        }
    }

    public function getSchedule(Schedule $schedule)
    {
        $AllfoundSchedule = $this->EntityManager->getRepository(Schedule::class)->findAll();
        foreach ($AllfoundSchedule as $_schedule){
            /**
             * @var Schedule $_schedule
             */
            if($schedule->getId() == $_schedule->getId()){
                $foundSchedule  = $_schedule->getArray();
                return $foundSchedule;
            }
        }
        return null;
    }

    public function getAllSchedule()
    {
        $foundSchedules = [];
        try {
            $AllfoundSchedule = $this->EntityManager->getRepository(Schedule::class)->findAll();
        }catch (\Exception $exception){
            print $exception ;
        }
        foreach ($AllfoundSchedule as $schedule){

            $foundSchedules[] = $schedule->getArray();
        }
        return  $foundSchedules;
    }

    public function updateSchedule(Schedule $schedule)
    {
        if($schedule->getId()) {
            $this->EntityManager->persist($schedule);
            $this->EntityManager->flush();
            if ($schedule->getId()) {
                return $schedule;
            } else {
                return null;
            }
        }
        return false;
    }

    public function removeSchedule(Schedule $schedule)
    {
        if($schedule){
            /**
             * @var Schedule $foundSchedule
             */
            $foundSchedule = $this->getSchedule($schedule);
            if($foundSchedule){
                $this->EntityManager->remove($foundSchedule);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    //Favorite

    public function addFavorite(Favorite $favorite)
    {
        $favorite->setId(null);
        $favorite->setIsActive(1);
        $favorite->setIsDeleted(0);
        $favorite->setCreatedDate(new \DateTime('now'));
        $favorite->setUpdatedDate(new \DateTime('now'));
        try {
            $this->EntityManager->persist($favorite);
            $this->EntityManager->flush();
        }catch (\Exception $exception)
        {
            print $exception;
        }
        if($favorite->getId()){
            return $favorite;
        }else{
            return null;
        }
    }

    public function getFavorite(Favorite $favorite)
    {
        $AllfoundFavorite = $this->EntityManager->getRepository(Favorite::class)->findAll();
        foreach ($AllfoundFavorite as $_favorite){
            /**
             * @var Favorite $_favorite
             */
            if($favorite->getId() == $_favorite->getId()){
                $foundFavorite  = $_favorite->getArray();
                return $foundFavorite;
            }
        }
        return null;
    }

    public function getUserFavorite(Favorite $favorite)
    {
       $foundFavorites = [];
        $userid = $favorite->getUser()->getId();
        try{
            $AllfoundFavorite = $this->EntityManager->getRepository(Favorite::class)->createQueryBuilder('userFav')
                ->Andwhere('userFav.user = :searchTerm')->setParameter('searchTerm',$userid)->getQuery()->execute();
        }catch (\Exception $exception) {
            print $exception;
        }
        foreach ($AllfoundFavorite as $_favorite){
                $foundFavorites  = $_favorite;
        }
        return $AllfoundFavorite;
    }

    public function getAllFavorite()
    {
        $foundFavorites = [];
        try {
            $AllfoundFavorite = $this->EntityManager->getRepository(Favorite::class)->findAll();
        }catch (\Exception $exception){
            print $exception ;
        }
        foreach ($AllfoundFavorite as $favorite){

            $foundFavorites[] = $favorite;
        }
        return  $foundFavorites;
    }

    public function updateFavorite(Favorite $favorite)
    {
        if($favorite->getId()) {
            $this->EntityManager->persist($favorite);
            $this->EntityManager->flush();
            if ($favorite->getId()) {
                return $favorite;
            } else {
                return null;
            }
        }
        return false;
    }

    public function removeFavorite(Favorite $favorite)
    {
        if($favorite){
            /**
             * @var Favorite $foundFavorite
             */
            $foundFavorite = $this->getFavorite($favorite);
            if($foundFavorite){
                $this->EntityManager->remove($foundFavorite);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    //denomination
    public function addDenomination(Denomination $denomination)
    {
        $denomination->setId(null);
        $denomination->setIsActive(1);
        $denomination->setIsDeleted(0);
        $denomination->setCreatedDate(new \DateTime('now'));
        $denomination->setUpdatedDate(new \DateTime('now'));
        $this->EntityManager->persist($denomination);
        $this->EntityManager->flush();
        if($denomination->getId()){
            return $denomination;
        }else{
            return null;
        }
    }

    public function getDenomination(Denomination $denomination)
    {

        try{
            $AllfoundDenomination = $this->EntityManager->getRepository(Denomination::class)->findAll();
        }catch (\Exception $exception){
            print $exception;
        }

        foreach ($AllfoundDenomination as $_denomination){
            /**
             * @var Denomination $_denomination
             */
            if($denomination->getId() == $_denomination->getId()){
                $foundDenomination  = $_denomination->getArray();
                return $foundDenomination;
            }
        }
        return null;
    }

    public function getAllDenomination()
    {
        $foundDenomination = [];
        try {
            $AllfoundDenomination = $this->EntityManager->getRepository(Denomination::class)->findAll();
        }catch (\Exception $exception){
            print $exception ;
        }
        foreach ($AllfoundDenomination as $denomination){
            $foundDenomination[] = $denomination->getArray();
        }
        return  $foundDenomination;
    }

    public function updateDenomination(Denomination $denomination)
    {
        if($denomination->getId()) {
            $this->EntityManager->persist($denomination);
            $this->EntityManager->flush();
            if ($denomination->getId()) {
                return $denomination;
            } else {
                return null;
            }
        }
        return false;
    }

    public function removeDenomination(Denomination $denomination)
    {
        if($denomination){
            /**
             * @var Denomination $foundDenomination
             */
            $foundDenomination = $this->getDenomination($denomination);
            if($foundDenomination){
                $this->EntityManager->remove($foundDenomination);
                $this->EntityManager->flush();
                return true;
            }else{
                return false;
            }
        }
        return false;
    }


}


