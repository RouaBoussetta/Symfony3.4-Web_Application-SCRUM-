<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Meeting
 *
 * @ORM\Table(name="meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetingRepository")
 */
class Meeting implements NotifiableInterface
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
     * @var \Date
     * @Assert\NotBlank
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Time
     * @Assert\NotBlank
     * @ORM\Column(name="time", type="time", nullable=false)
     */
    private $time;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max = 20)
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $titleMeeting;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max = 200)
     * @Assert\Regex(pattern="/[a-zA-Z0-9,.!]/")
     * @ORM\Column(name="goal", type="string", length=255, nullable=false)
     */
    private $goal;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="issues", type="string", length=255, nullable=false)
     * @Assert\Length(max = 200)
     * @Assert\Regex(pattern="/[a-zA-Z0-9,.!]/")
     */
    private $issues;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $type;


    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(max = 200)
     * @Assert\Regex(pattern="/[a-zA-Z0-9]/")
     */
    private $duration;
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(max = 200)
     * @Assert\Regex(pattern="/[a-zA-Z0-9]/")
     */
    private $location;





    /**
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id",referencedColumnName="idProject")
     */
    private $project;

    /**
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="meeting")
     * @ORM\JoinTable(name="meeting_user")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="ClaimMeeting", mappedBy="claim_meeting")
     */
    private $claim;

    /**
     * @var string
     *
     * @ORM\Column(name="organizedBy", type="string", length=255, nullable=false)
     *
     */
    private $organizedBy;

    /**
     * @return string
     */
    public function getOrganizedBy()
    {
        return $this->organizedBy;
    }

    /**
     * @param string $organizedBy
     */
    public function setOrganizedBy($organizedBy)
    {
        $this->organizedBy = $organizedBy;
    }









    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
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
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \Time $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


    /**
     * @return string
     */
    public function getTitleMeeting()
    {
        return $this->titleMeeting;
    }

    /**
     * @param string $titleMeeting
     */
    public function setTitleMeeting($titleMeeting)
    {
        $this->titleMeeting = $titleMeeting;
    }



    /**
     * @return string
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * @param string $goal
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /**
     * @return string
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param string $issues
     */
    public function setIssues($issues)
    {
        $this->issues = $issues;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }



    /**
     * @return \Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getClaim()
    {
        return $this->claim;
    }

    /**
     * @param mixed $claim
     */
    public function setClaim($claim)
    {
        $this->claim = $claim;
    }

    /**
     * @inheritDoc
     */
    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('notifff')
            ->setDescription($this->titleMeeting)
            ->setDate(new \DateTime())

            ->setRoute('meeting_calendar')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;
    }

    /**
     * @inheritDoc
     */
    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification=new Notification();
        $notification->setTitle('notifff')
            ->setDescription($this->titleMeeting)
            ->setDate(new \DateTime())
            ->setRoute('meeting_calendar')
            ->getParameters(array('id'=>$this));

        $builder->addNotification($notification);

        return $builder;    }

    /**
     * @inheritDoc
     */
    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;

    }
}

