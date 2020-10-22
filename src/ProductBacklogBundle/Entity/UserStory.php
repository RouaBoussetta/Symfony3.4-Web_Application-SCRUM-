<?php

namespace ProductBacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * UserStory
 *
 * @ORM\Table(name="user_story")
 * @ORM\Entity(repositoryClass="ProductBacklogBundle\Repository\UserStoryRepository")
 */
class UserStory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user_story", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $idUserStory;

    /**
     * @var string
     *
     * @ORM\Column(name="user_story_description", type="string", length=150, nullable=false)
     *
     */
    private $userStoryDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="doing", type="integer", nullable=false)
     *
     */
    private $doing = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="total_estimation_userStory_jours", type="integer", nullable=true)
     *
     */
    private $totalEstimationUserstoryJours ;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     *
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_PB", type="integer", nullable=false)
     *
     */
    private $idPb = '0';

    /**
     * @var \Feature
     *
     * @ORM\ManyToOne(targetEntity="Feature")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feature", referencedColumnName="id_feature")
     * })
     */
    private $idFeature;

    /**
     * @return int
     */
    public function getIdUserStory()
    {
        return $this->idUserStory;
    }

    /**
     * @param int $idUserStory
     */
    public function setIdUserStory($idUserStory)
    {
        $this->idUserStory = $idUserStory;
    }

    /**
     * @return string
     */
    public function getUserStoryDescription()
    {
        return $this->userStoryDescription;
    }

    /**
     * @param string $userStoryDescription
     */
    public function setUserStoryDescription($userStoryDescription)
    {
        $this->userStoryDescription = $userStoryDescription;
    }

    /**
     * @return int
     */
    public function getDoing()
    {
        return $this->doing;
    }

    /**
     * @param int $doing
     */
    public function setDoing($doing)
    {
        $this->doing = $doing;
    }

    /**
     * @return int
     */
    public function getTotalEstimationUserstoryJours()
    {
        return $this->totalEstimationUserstoryJours;
    }

    /**
     * @param int $totalEstimationUserstoryJours
     */
    public function setTotalEstimationUserstoryJours($totalEstimationUserstoryJours)
    {
        $this->totalEstimationUserstoryJours = $totalEstimationUserstoryJours;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getIdPb()
    {
        return $this->idPb;
    }

    /**
     * @param int $idPb
     */
    public function setIdPb($idPb)
    {
        $this->idPb = $idPb;
    }

    /**
     * @return \Feature
     */
    public function getIdFeature()
    {
        return $this->idFeature;
    }

    /**
     * @param \Feature $idFeature
     */
    public function setIdFeature($idFeature)
    {
        $this->idFeature = $idFeature;
    }

}

