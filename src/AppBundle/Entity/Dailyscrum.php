<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Notification;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Dailyscrum
 *
 * @ORM\Table(name="dailyscrum", indexes={@ORM\Index(name="id_type", columns={"id_type"})})
 * @ORM\Entity
 */
class Dailyscrum implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_daily", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDaily;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="yesterdaywork", type="string", length=254, nullable=false)
     */
    private $yesterdaywork;

    /**
     * @var string
     *
     * @ORM\Column(name="todayplan", type="string", length=254, nullable=false)
     */
    private $todayplan;

    /**
     * @var string
     *
     * @ORM\Column(name="blockers", type="string", length=254, nullable=false)
     */
    private $blockers;

    /**
     * @var integer
     *
     * @ORM\Column(name="hrsbrunt", type="integer", nullable=false)
     */
    private $hrsbrunt;

    /**
     * @var integer
     *
     * @ORM\Column(name="hrscompleted", type="integer", nullable=false)
     */
    private $hrscompleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_creation", type="time", nullable=false)
     */
    private $timeCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="date", nullable=false)
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_modification", type="time", nullable=false)
     */
    private $timeModification;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="createdby",referencedColumnName="id")
     */
    private $username;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }




    /**
     * @var int
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     */
    private $idType ;

    /**
     * @return int
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param int $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
    }



    /**
     * @return int
     */
    public function getIdDaily()
    {
        return $this->idDaily;
    }

    /**
     * @param int $idDaily
     */
    public function setIdDaily($idDaily)
    {
        $this->idDaily = $idDaily;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getYesterdaywork()
    {
        return $this->yesterdaywork;
    }

    /**
     * @param string $yesterdaywork
     */
    public function setYesterdaywork($yesterdaywork)
    {
        $this->yesterdaywork = $yesterdaywork;
    }

    /**
     * @return string
     */
    public function getTodayplan()
    {
        return $this->todayplan;
    }

    /**
     * @param string $todayplan
     */
    public function setTodayplan($todayplan)
    {
        $this->todayplan = $todayplan;
    }

    /**
     * @return string
     */
    public function getBlockers()
    {
        return $this->blockers;
    }

    /**
     * @param string $blockers
     */
    public function setBlockers($blockers)
    {
        $this->blockers = $blockers;
    }

    /**
     * @return int
     */
    public function getHrsbrunt()
    {
        return $this->hrsbrunt;
    }

    /**
     * @param int $hrsbrunt
     */
    public function setHrsbrunt($hrsbrunt)
    {
        $this->hrsbrunt = $hrsbrunt;
    }

    /**
     * @return int
     */
    public function getHrscompleted()
    {
        return $this->hrscompleted;
    }

    /**
     * @param int $hrscompleted
     */
    public function setHrscompleted($hrscompleted)
    {
        $this->hrscompleted = $hrscompleted;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return \DateTime
     */
    public function getTimeCreation()
    {
        return $this->timeCreation;
    }

    /**
     * @param \DateTime $timeCreation
     */
    public function setTimeCreation($timeCreation)
    {
        $this->timeCreation = $timeCreation;
    }

    /**
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param \DateTime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return \DateTime
     */
    public function getTimeModification()
    {
        return $this->timeModification;
    }


    /**
     * @param \DateTime $timeModification
     */
    public function setTimeModification($timeModification)
    {
        $this->timeModification = $timeModification;
    }


    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('Daily Scrum notif')
            ->setDescription($this->title)
            ->setDate(new \DateTime())

            ->setRoute('document_dailyscrum')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('Daily Scrum notif')
            ->setDescription($this->title)
            ->setDate(new \DateTime())
            ->setRoute('dailyscrum_new')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }
}

