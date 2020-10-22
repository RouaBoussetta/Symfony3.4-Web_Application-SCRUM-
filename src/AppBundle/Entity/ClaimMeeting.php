<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ClaimMeeting
 *
 * @ORM\Table(name="claim_meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClaimMeetingRepository")
 */
class ClaimMeeting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;




    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/[0-9]/")
     * @Assert\Length(8)
     */
    private $tel;


    /**
     * @var string
     *
     * @ORM\Column(name="available", type="string", length=255)
     * @Assert\NotBlank
     */
    private $available;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     * @Assert\Length(max=50)
     */
    private $other;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     * @Assert\Length(max=100)
     */
    private $reason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     *
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="Meeting")
     * @ORM\JoinColumn(name="meeting", referencedColumnName="id",nullable=false)
     */
    private $meeting;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param string $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @param string $other
     */
    public function setOther($other)
    {
        $this->other = $other;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * @param mixed $meeting
     */
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;
    }

}

