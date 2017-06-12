<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:24 PM
 */

namespace WedeChurch\Services;


use Doctrine\ORM\EntityManager;
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
        // TODO: Implement addUser() method.
    }

    public function getUser(User $user)
    {
        // TODO: Implement getUser() method.
    }

    public function getUserByID(User $user)
    {
        // TODO: Implement getUserByID() method.
    }

    public function checkUser(User $user)
    {
        // TODO: Implement checkUser() method.
    }

    public function updateUser(User $user)
    {
        // TODO: Implement updateUser() method.
    }

    public function removeUser(User $user)
    {
        // TODO: Implement removeUser() method.
    }

}