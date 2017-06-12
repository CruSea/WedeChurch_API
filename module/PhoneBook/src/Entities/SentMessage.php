<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 9:12 PM
 */

namespace PhoneBook\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sent_messages")
 */
class SentMessage extends BaseTable
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
     * @ORM\Column(name="message_to", type="string", unique=false, nullable=false)
     */
    protected $message_to;
    /**
     * @ORM\Column(name="is_sent", type="boolean", unique=false, nullable=false)
     */
    protected $isSent;
}