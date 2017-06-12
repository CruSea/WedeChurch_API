<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:25 PM
 */

namespace WedeChurch\Services;


use WedeChurch\Entities\User;

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
}