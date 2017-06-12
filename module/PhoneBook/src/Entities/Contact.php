<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 9:01 PM
 */

namespace PhoneBook\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="contacts")
 */
class Contact extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="full_name", type="string", unique=false, nullable=false)
     */
    protected $fullName;
    /**
     * @ORM\Column(name="phone_number", type="string", unique=false, nullable=false)
     */
    protected $phoneNumber;
    /**
     * @ORM\Column(name="email", type="string", unique=false, nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(name="description", type="string", unique=false, nullable=true)
     */
    protected $description;
}