<?php
/**
 * Created by PhpStorm.
 * User: fre
 * Date: 6/21/17
 * Time: 8:53 AM
 */

namespace WedeChurch\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="church")
 */
class Church extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string", unique=false, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(name="country", type="string", unique=false, nullable=false)
     */
    protected $country;
    /**
     * @ORM\Column(name="cities", type="string", unique=false, nullable=true)
     */
    protected $cities;
    /**
     * @ORM\Column(name="state", type="string", unique=false, nullable=true)
     */
    protected $state;
    /**
     * @ORM\Column(name="location", type="string", unique=false, nullable=true)
     */
    protected $location;
    /**
     * @ORM\Column(name="latitude", type="string", unique=false, nullable=true)
     */
    protected $latitude;
    /**
     * @ORM\Column(name="longitude", type="string", unique=false, nullable=true)
     */
    protected $longitude;
    /**
     * @ORM\Column(name="phone", type="string", unique=false, nullable=true)
     */
    protected $phone;
    /**
     * @ORM\Column(name="WebUrl", type="string", unique=false, nullable=true)
     */
    protected $WebUrl;
    /**
     *
     * @ORM\ManyToOne(targetEntity="denomination")
     * @ORM\JoinColumn(name="denomination_id", referencedColumnName="id")
     * @var Denomination $id
     */
    protected $denomination_id;
    /**
     *
     * @ORM\Column(name="banner", type="string", unique=false, nullable=true)
     */
    protected $banner;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=true)
     */
    protected $description;
    /**
     * @ORM\Column(name="logo", type="string", unique=false, nullable=true)
     */
    protected $logo;
    /**
     *
     * @ORM\ManyToOne(targetEntity="church")
     * @ORM\JoinColumn(name="parent_church_id", referencedColumnName="id")
     * @var Church $id
     */

    protected $parent_church_id;

    /**
     * @return mixed
     */
    public function getisDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

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
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @param mixed $cities
     */
    public function setCities($cities)
    {
        $this->cities = $cities;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getWebUrl()
    {
        return $this->WebUrl;
    }

    /**
     * @param mixed $WebUrl
     */
    public function setWebUrl($WebUrl)
    {
        $this->WebUrl = $WebUrl;
    }

    /**
     * @return mixed
     */
    public function getDenominationId()
    {
        return $this->denomination_id;
    }

    /**
     * @param mixed $denomination_id
     */
    public function setDenominationId($denomination_id)
    {
        $this->denomination_id = $denomination_id;
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
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getParentChurchId()
    {
        return $this->parent_church_id;
    }

    /**
     * @param mixed $parent_church_id
     */
    public function setParentChurchId($parent_church_id)
    {
        $this->parent_church_id = $parent_church_id;
    }

    public function getArray(){
        return array(
            'id'=>$this->getId(),
            'name'=>$this->getName(),
            'country' => $this->getCountry(),
            'cities'=>$this->getCities(),
            'location'=>$this->getLocation(),
            'latitude'=>$this->getLatitude(),
            'longitude'=>$this->getLongitude(),
            'Phone'=>$this->getPhone(),
            'banner'=>$this->getBanner(),
            'WebUrl'=>$this->getWebUrl(),
            'denomination_id'=>$this->getDenominationId(),
            'description'=>$this->getDescription(),
            'logo'=>$this->getLogo(),
            'parent_church_id'=>$this->getParentChurchId(),
            'state' => $this->getState(),
            'is_deleted'=>$this->getIsDeleted(),
            'is_active'=>$this->getIsActive(),
            'updated_by'=>$this->getUpdatedBy(),
            'updated_date'=>$this->getUpdatedDate(),
            'created_by'=>$this->getCreatedBy(),
            'created_date'=>$this->getCreatedDate(),
        );
    }


}