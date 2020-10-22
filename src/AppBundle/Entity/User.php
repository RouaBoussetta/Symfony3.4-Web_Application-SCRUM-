<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     */
    private $name;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z@.]/")
     */
    private $userMail;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $userPassword;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[0-9]/")
     * @Assert\Length(8)
     */
    private $userPhone;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $userAddress;

    /**
     * @var string

     * @Assert\Image()
     *@ORM\Column(type="string",length=255,nullable=true)
     */
    private $userPhoto;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Length(8)
     * @Assert\Regex(pattern="/[0-9]/")
     */
    private $userCin;


    /**
     * @ORM\Column(type="date",length=255,nullable=true)
     */
    private $userDayBirth;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $userSite;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     */
    private $nationality;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     */
    private $speciality;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Assert\Regex(pattern="/[a-zA-Z]/")
     */
    private $bio;


    /**
     * Many Users have Many meetings.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Meeting", mappedBy="user")
     * @ORM\JoinTable(name="meeting_user")
     */
    private $meeting;

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


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string|null $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

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
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * @param mixed $userMail
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;
    }

    /**
     * @return mixed
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param mixed $userPassword
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return mixed
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * @param mixed $userPhone
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = $userPhone;
    }

    /**
     * @return mixed
     */
    public function getUserAddress()
    {
        return $this->userAddress;
    }

    /**
     * @param mixed $userAddress
     */
    public function setUserAddress($userAddress)
    {
        $this->userAddress = $userAddress;
    }

    /**
     * @return mixed
     */
    public function getUserPhoto()
    {
        return $this->userPhoto;
    }

    /**
     * @param mixed $userPhoto
     */
    public function setUserPhoto($userPhoto)
    {
        $this->userPhoto = $userPhoto;
    }

    /**
     * @return mixed
     */
    public function getUserCin()
    {
        return $this->userCin;
    }

    /**
     * @param mixed $userCin
     */
    public function setUserCin($userCin)
    {
        $this->userCin = $userCin;
    }

    /**
     * @return mixed
     */
    public function getUserDayBirth()
    {
        return $this->userDayBirth;
    }

    /**
     * @param mixed $userDayBirth
     */
    public function setUserDayBirth($userDayBirth)
    {
        $this->userDayBirth = $userDayBirth;
    }

    /**
     * @return mixed
     */
    public function getUserSite()
    {
        return $this->userSite;
    }

    /**
     * @param mixed $userSite
     */
    public function setUserSite($userSite)
    {
        $this->userSite = $userSite;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param mixed $speciality
     */
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;
    }






}

