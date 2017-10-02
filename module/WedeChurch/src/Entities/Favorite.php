<?php
/**
 * Created by PhpStorm.
 * User: frezertade
 * Date: 9/18/17
 * Time: 3:41 PM
 */

namespace WedeChurch\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Favorite")
 */
class Favorite extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * @var User $user
     */
    protected $user;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Church")
     * @ORM\JoinColumn(name="church", referencedColumnName="id")
     * @var Church $church
     */
    protected $church;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Church
     */
    public function getChurch()
    {
        return $this->church;
    }

    /**
     * @param Church $church
     */
    public function setChurch($church)
    {
        $this->church = $church;
    }
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'user'=>$this->getUser()->getId(),
            'church'=>$this->getChurch()->getId(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}