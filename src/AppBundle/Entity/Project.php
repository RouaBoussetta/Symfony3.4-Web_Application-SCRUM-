<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project implements NotifiableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProject", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idProject;

    /**
     * @var string
     *
     * @ORM\Column(name="projectTitle", type="string", length=255)
     */
    private $projectTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;



    /**
     * @var Date
     *
     * @ORM\Column(name="date_creation", type="date", length=255)
     */
    private $date_creation;


    /**
     * @var Time
     *
     * @ORM\Column(name="time_creation", type="time", length=255)
     */
    private $time_creation;



    /**
     * @var Date
     *
     * @ORM\Column(name="deadLine", type="date", length=255)
     */
    private $deadLine;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var float
     *
     * @ORM\Column(name="version", type="float", length=255)
     */
    private $version;




    /**
     * Get id
     *
     * @return int
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * Set projectTitle
     *
     * @param string $projectTitle
     *
     * @return Project
     */
    public function setProjectTitle($projectTitle)
    {
        $this->projectTitle = $projectTitle;

        return $this;
    }

    /**
     * Get projectTitle
     *
     * @return string
     */
    public function getProjectTitle()
    {
        return $this->projectTitle;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }






    /**
     * @return string
     */
    public function getDeadLine()
    {
        return $this->deadLine;
    }

    /**
     * @param string $deadLine
     */
    public function setDeadLine($deadLine)
    {
        $this->deadLine = $deadLine;
    }








    /**
     * Set category
     *
     * @param string $category
     *
     * @return Project
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param float $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return Date
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param Date $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return Time
     */
    public function getTimeCreation()
    {
        return $this->time_creation;
    }

    /**
     * @param Time $time_creation
     */
    public function setTimeCreation($time_creation)
    {
        $this->time_creation = $time_creation;
    }





    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Hello')
            ->setDescription('New project has been added: "'.$this->projectTitle.'"')
            ->setRoute('project_show')
            ->setParameters(array('idProject' => $this->idProject))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('coucou')
            ->setDescription('"'.$this->projectTitle.'" has been updated:')
            ->setRoute('project_show')
            ->setParameters(array('idProject' => $this->idProject))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;

    }


}

