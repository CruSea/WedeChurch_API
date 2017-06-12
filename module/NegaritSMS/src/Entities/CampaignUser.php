<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:51 AM
 */

namespace NegaritSMS\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="campaign_users",uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"campaign_id", "user_id"})})
 */
class CampaignUser extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Campaign")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     * @var Campaign $campaign
     */
    protected $campaign;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User $user
     */
    protected $user;

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
     * @return Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param Campaign $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
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
    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'campaign'=>$this->getCampaign()->getArray(),
            'user'=>$this->getUser()->getArray(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }
}