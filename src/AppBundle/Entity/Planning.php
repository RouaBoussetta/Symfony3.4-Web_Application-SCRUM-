<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Planning
 *
 * @ORM\Table(name="planning", indexes={@ORM\Index(name="id_type", columns={"id_type"})})
 * @ORM\Entity
 */
class Planning implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_plan", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPlan;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="analyse", type="string", length=254, nullable=false)
     */
    private $analyse;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluate", type="string", length=254, nullable=false)
     */
    private $evaluate;

    /**
     * @var string
     *
     * @ORM\Column(name="product", type="string", length=254, nullable=false)
     */
    private $product;

    /**
     * @var string
     *
     * @ORM\Column(name="sprintgoal", type="string", length=254, nullable=false)
     */
    private $sprintgoal;

    /**
     * @var string
     *
     * @ORM\Column(name="tasks", type="string", length=254, nullable=false)
     */
    private $tasks;

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
     * @var int
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     */
    private $idType;

    /**
     * @return int
     */
    public function getIdPlan()
    {
        return $this->idPlan;
    }

    /**
     * @param int $idPlan
     */
    public function setIdPlan($idPlan)
    {
        $this->idPlan = $idPlan;
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
    public function getAnalyse()
    {
        return $this->analyse;
    }

    /**
     * @param string $analyse
     */
    public function setAnalyse($analyse)
    {
        $this->analyse = $analyse;
    }

    /**
     * @return string
     */
    public function getEvaluate()
    {
        return $this->evaluate;
    }

    /**
     * @param string $evaluate
     */
    public function setEvaluate($evaluate)
    {
        $this->evaluate = $evaluate;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getSprintgoal()
    {
        return $this->sprintgoal;
    }

    /**
     * @param string $sprintgoal
     */
    public function setSprintgoal($sprintgoal)
    {
        $this->sprintgoal = $sprintgoal;
    }

    /**
     * @return string
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param string $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
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
     * @return string
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * @param string $createdby
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
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
        $notification->setTitle('New Planning Document')
            ->setDescription($this->title)
            ->setDate(new \DateTime())

            ->setRoute('document_planning')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('New Planning Document')
            ->setDescription($this->title)
            ->setDate(new \DateTime())
            ->setRoute('planning_new')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }


}

