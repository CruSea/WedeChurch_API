<?php
/**
 * Created by PhpStorm.
 * User: frezertade
 * Date: 9/18/17
 * Time: 3:24 PM
 */

namespace WedeChurch\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="schedule")
 */
class Schedule extends BaseTable
{
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return schedule_category
     */
    public function getScheduleCategoryId()
    {
        return $this->schedule_category_id;
    }

    /**
     * @param schedule_category $schedule_category_id
     */
    public function setScheduleCategoryId($schedule_category_id)
    {
        $this->schedule_category_id = $schedule_category_id;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param mixed $end_time
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

    /**
     * @return mixed
     */
    public function getRedundancy()
    {
        return $this->redundancy;
    }

    /**
     * @param mixed $redundancy
     */
    public function setRedundancy($redundancy)
    {
        $this->redundancy = $redundancy;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string", unique=false, nullable=false)
     */
    protected $name;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Schedule_category")
     * @ORM\JoinColumn(name="schedule_category_id", referencedColumnName="id")
     * @var schedule_category $schedule_category_id
     */
    protected $schedule_category_id;
    /**
     * @ORM\Column(name="start_time", type="time", unique=false, nullable=false)
     */
    protected $start_time;
    /**
     * @ORM\Column(name="end_time", type="time", unique=false, nullable=false)
     */
    protected $end_time;
    /**
     * @ORM\Column(name="redundancy", type="string", unique=false, nullable=false)
     */
    protected $redundancy;


    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'name'=>$this->getName(),
            'start_time'=>$this->getStartTime(),
            'end_time'=>$this->getEndTime(),
            'redundancy'=>$this->getRedundancy(),
            'schedule_category_id'=>$this->getScheduleCategoryId(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }

}