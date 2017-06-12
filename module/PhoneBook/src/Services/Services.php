<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:22 PM
 */

namespace PhoneBook\Services;


use Doctrine\ORM\EntityManager;
use PhoneBook\Entities\Group;
use PhoneBook\Entities\Privilege;
use PhoneBook\Entities\User;

class Services implements ServicesMethods
{
    /**
     * @var EntityManager $EntityManager
     */
    protected $EntityManager;

    /**
     * Services constructor.
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
            $foundUser = $this->EntityManager->getRepository(User::class)->find($user->getId());
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

    public function getAllUsers()
    {
        $foundUsers = [];
        $allUser = $this->EntityManager->getRepository(User::class)->findAll();
        foreach ($allUser as $_user){
            /**
             * @var User $_user
             */
            $foundUsers[] = $_user->getArray();
        }
        return $foundUsers;
    }


    public function checkUser(User $user)
    {
        $allUsers = $this->EntityManager->getRepository(User::class)->findAll();
        foreach ($allUsers as $_user){
            /**
             * @var User $_user
             */

            if(($_user->getUserPass() === sha1($user->getUserPass())) && ($_user->getUserName() === $user->getUserName())){
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
            $foundPrivileges[] = $privilege->getArray();
        }
        return $foundPrivileges;
    }

    public function addNewGroup(Group $group)
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

    public function getAllGroup()
    {
        $foundGroups = [];
        $allGroups = $this->EntityManager->getRepository(Group::class)->findAll();
        foreach ($allGroups as $group){
            /**
             * @var Group $group
             */
            $foundGroups[] = $group->getArray();
        }
        return $foundGroups;
    }

    public function removeGroup(Group $group)
    {
        if($group){
            /**
             * @var Group $foundGroup
             */
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


}