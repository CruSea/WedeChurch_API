<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:25 PM
 */

namespace WedeChurch\Services;


use WedeChurch\Entities\Privilege;
use WedeChurch\Entities\User;
use WedeChurch\Entities\Church;
use WedeChurch\Entities\Event;
use WedeChurch\Entities\Event_category;

interface ServicesMethods
{
    /**
     * User Table
     * @return mixed
     */
    public function addUser(User $user);
    public function getUser(User $user);
    public function getUserByID(User $user);
    public function checkUser(User $user);
    public function updateUser(User $user);
    public function removeUser(User $user);

    /**
     * Company Privilege
     * @return mixed
     */
    public function addPrivilege(Privilege $privilege);
    public function getPrivilege(Privilege $privilege);
    public function getAllPrivilege();
    public function getLessPrivilege(Privilege $privilege);

    /**
     * Table church
     * @return mixed
     */
    public function addChurch(Church $church);
    public function getChurch(Church $church);
    public function getAllChurch();
    public function updateChurch(Church $church);
    public function removeChurch(Church $church);


    /**
     * Table Event
     * @return mixed
     */
    public function addEvent(Event $event);
    public function getEvent(Event $event);
    public function getAllEvent();
    public function updateEvent(Event $event);
    public function removeEvent(Event $event);

    /**
     * Table Event
     * @return mixed
     */
    public function addEvent_Category(Event_category $event_category);
    public function getEvent_Category(Event_category $event_category);
    public function getAllEvent_Category();
    public function updateEvent_Category(Event_category $event_category);
    public function removeEvent_Category(Event_category $event_category);
}