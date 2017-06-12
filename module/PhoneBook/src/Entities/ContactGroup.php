<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 9:07 PM
 */

namespace PhoneBook\Entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="contact_groups")
 */
class ContactGroup extends BaseTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * @var Contact $contact
     */
    protected $contact;
    /**
     * One Product has Many Features.
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var Group $group
     */
    protected $group;
}