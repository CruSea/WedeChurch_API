<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:23 PM
 */

namespace PhoneBook\Services;


use PhoneBook\Entities\Group;
use PhoneBook\Entities\Privilege;
use PhoneBook\Entities\User;

interface ServicesMethods
{
    /**
     * User Table
     * @return mixed
     */
    public function addUser(User $user);
    public function getUser(User $user);
    public function getUserByID(User $user);
    public function getAllUsers();
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

    /**
     *  Groups
     * @return mixed
     */
    public function addNewGroup(Group $group);
    public function getGroup(Group $group);
    public function getAllGroup();
    public function removeGroup(Group $group);;
}