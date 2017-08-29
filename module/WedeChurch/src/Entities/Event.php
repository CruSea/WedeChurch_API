<?php
/**
 * Created by PhpStorm.
 * User: fre
 * Date: 6/21/17
 * Time: 9:20 AM
 */

namespace WedeChurch\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event extends BaseTable
{
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
     * @ORM\ManyToOne(targetEntity="church")
     * @ORM\JoinColumn(name="church_id", referencedColumnName="id")
     * @var church $church_id
     */
    protected $church_id;
    /**
     * @ORM\Column(name="location", type="string", unique=false, nullable=false)
     */
    protected $location;
    /**
     * @ORM\Column(name="latitude", type="string", unique=false, nullable=false)
     */
    protected $latitude;
    /**
     * @ORM\Column(name="longitude", type="string", unique=false, nullable=false)
     */
    protected $longitude;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="event_category")
     * @ORM\JoinColumn(name="event_category_id", referencedColumnName="id")
     * @var event_category $event_category_id
     */
    protected $event_category_id;
    /**
     * @ORM\Column(name="banner", type="string", unique=false, nullable=false)
     */
    protected $banner;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=false)
     */
    protected $description;
    /**
     * @ORM\Column(name="contact_info", type="string", unique=false, nullable=false)
     */
    protected $contact_info;
    /**
     * @ORM\Column(name="start_date", type="datetime", unique=false, nullable=false)
     */
    protected $start_date;
    /**
     * @ORM\Column(name="end_date", type="datetime", unique=false, nullable=false)
     */
    protected $end_date;

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
     * @return church
     */
    public function getChurchId()
    {
        return $this->church_id;
    }

    /**
     * @param church $church_id
     */
    public function setChurchId($church_id)
    {
        $this->church_id = $church_id;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return event_category
     */
    public function getEventCatagoryId()
    {
        return $this->event_catagory_id;
    }

    /**
     * @param event_category $event_category_id
     */
    public function setEventCatagoryId($event_catagory_id)
    {
        $this->event_catagory_id = $event_catagory_id;
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getContactInfo()
    {
        return $this->contact_info;
    }

    /**
     * @param mixed $contact_info
     */
    public function setContactInfo($contact_info)
    {
        $this->contact_info = $contact_info;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'church_id' =>$this->getChurchId(),
            'location' => $this ->getLocation(),
            'latitude' => $this ->getLatitude(),
            'longitude' => $this ->getLongitude(),
            'event_category_id'=>$this->getEventCatagoryId(),
            'banner'=>$this->getBanner(),
            'description'=>$this->getDescription(),
            'contact_info'=>$this->getContactInfo(),
            'start_date'=>$this->getStartDate(),
            'end_date'=>$this->getEndDate(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy()->getId(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy()->getId(),
            'created_date'=>$this->getCreatedDate(),
        );
    }

}