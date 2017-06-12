<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 9:15 PM
 */

namespace PhoneBook\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_messages")
 */
class GroupMessage extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(name="message", type="string", unique=false, nullable=false)
     */
    protected $message;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * @var Group $group
     */
    protected $group;
}