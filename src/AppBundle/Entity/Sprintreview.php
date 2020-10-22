<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Sprintreview
 *
 * @ORM\Table(name="sprintreview", indexes={@ORM\Index(name="id_type", columns={"id_type"})})
 * @ORM\Entity
 */
class Sprintreview implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_review", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReview;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="projectname", type="string", length=254, nullable=false)
     */
    private $projectname;

    /**
     * @var string
     *
     * @ORM\Column(name="thingstodemo", type="string", length=254, nullable=false)
     */
    private $thingstodemo;

    /**
     * @var string
     *
     * @ORM\Column(name="quickupdates", type="string", length=254, nullable=false)
     */
    private $quickupdates;

    /**
     * @var string
     *
     * @ORM\Column(name="whatisnext", type="string", length=254, nullable=false)
     */
    private $whatisnext;

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
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="createdby",referencedColumnName="id")
     */
    private $user;

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



    /**
     * @var integer
     *
     * @ORM\Column(name="id_type", type="integer", nullable=true)
     */
    private $idType;

    /**
     * @return int
     */
    public function getIdReview()
    {
        return $this->idReview;
    }

    /**
     * @param int $idReview
     */
    public function setIdReview($idReview)
    {
        $this->idReview = $idReview;
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
    public function getProjectname()
    {
        return $this->projectname;
    }

    /**
     * @param string $projectname
     */
    public function setProjectname($projectname)
    {
        $this->projectname = $projectname;
    }

    /**
     * @return string
     */
    public function getThingstodemo()
    {
        return $this->thingstodemo;
    }

    /**
     * @param string $thingstodemo
     */
    public function setThingstodemo($thingstodemo)
    {
        $this->thingstodemo = $thingstodemo;
    }

    /**
     * @return string
     */
    public function getQuickupdates()
    {
        return $this->quickupdates;
    }

    /**
     * @param string $quickupdates
     */
    public function setQuickupdates($quickupdates)
    {
        $this->quickupdates = $quickupdates;
    }

    /**
     * @return string
     */
    public function getWhatisnext()
    {
        return $this->whatisnext;
    }

    /**
     * @param string $whatisnext
     */
    public function setWhatisnext($whatisnext)
    {
        $this->whatisnext = $whatisnext;
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


    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('New SprintReview Doc')
            ->setDescription($this->title)
            ->setDate(new \DateTime())

            ->setRoute('document_sprintreview')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('New SprintReview Doc')
            ->setDescription($this->title)
            ->setDate(new \DateTime())
            ->setRoute('sprintreview_new')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }
}

