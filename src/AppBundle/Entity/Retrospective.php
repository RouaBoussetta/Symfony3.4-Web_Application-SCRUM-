<?php

namespace AppBundle\Entity;
use AppBundle\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Retrospective
 *
 * @ORM\Table(name="retrospective", indexes={@ORM\Index(name="id_type", columns={"id_type"})})
 * @ORM\Entity
 */
class Retrospective implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_retro", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRetro;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="startdoing", type="string", length=254, nullable=false)
     */
    private $startdoing;

    /**
     * @var string
     *
     * @ORM\Column(name="stopdoing", type="string", length=254, nullable=false)
     */
    private $stopdoing;

    /**
     * @var string
     *
     * @ORM\Column(name="continuedoing", type="string", length=254, nullable=false)
     */
    private $continuedoing;

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
     * @var String
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
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     */
    private $idType;

    /**
     * @return int
     */
    public function getIdRetro()
    {
        return $this->idRetro;
    }

    /**
     * @param int $idRetro
     */
    public function setIdRetro($idRetro)
    {
        $this->idRetro = $idRetro;
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
    public function getStartdoing()
    {
        return $this->startdoing;
    }

    /**
     * @param string $startdoing
     */
    public function setStartdoing($startdoing)
    {
        $this->startdoing = $startdoing;
    }

    /**
     * @return string
     */
    public function getStopdoing()
    {
        return $this->stopdoing;
    }

    /**
     * @param string $stopdoing
     */
    public function setStopdoing($stopdoing)
    {
        $this->stopdoing = $stopdoing;
    }

    /**
     * @return string
     */
    public function getContinuedoing()
    {
        return $this->continuedoing;
    }

    /**
     * @param string $continuedoing
     */
    public function setContinuedoing($continuedoing)
    {
        $this->continuedoing = $continuedoing;
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
        $notification->setTitle('New Retrospective Doc')
            ->setDescription($this->title)
            ->setDate(new \DateTime())

            ->setRoute('document_retrospective')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('New Retrospective Doc')
            ->setDescription($this->title)
            ->setDate(new \DateTime())
            ->setRoute('retrospective_new')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }
}

