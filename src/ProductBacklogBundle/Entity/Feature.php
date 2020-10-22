<?php

namespace ProductBacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Feature
 *
 * @ORM\Table(name="feature")
 * @ORM\Entity(repositoryClass="ProductBacklogBundle\Repository\FeatureRepository")
 */
class Feature
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_feature", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     *
     */
    private $idFeature;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_feature", type="string", length=50, nullable=false)
     *
     */
    private $nomFeature;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_respensability", type="integer", nullable=true)
     *
     */
    private $idUserRespensability ='0' ;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_estimation_feature_jours", type="integer", nullable=true)
     *
     */
    private $totalEstimationFeatureJours = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="statue", type="integer", nullable=false)
     *
     */
    private $statue = '0';

    /**
     * @var \Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_theme", referencedColumnName="id_theme")
     * })
     */
    private $idTheme;

    /**
     * @return int
     */
    public function getIdFeature()
    {
        return $this->idFeature;
    }

    /**
     * @param int $idFeature
     */
    public function setIdFeature($idFeature)
    {
        $this->idFeature = $idFeature;
    }

    /**
     * @return string
     */
    public function getNomFeature()
    {
        return $this->nomFeature;
    }

    /**
     * @param string $nomFeature
     */
    public function setNomFeature($nomFeature)
    {
        $this->nomFeature = $nomFeature;
    }

    /**
     * @return int
     */
    public function getIdUserRespensability()
    {
        return $this->idUserRespensability;
    }

    /**
     * @param int $idUserRespensability
     */
    public function setIdUserRespensability($idUserRespensability)
    {
        $this->idUserRespensability = $idUserRespensability;
    }

    /**
     * @return int
     */
    public function getTotalEstimationFeatureJours()
    {
        return $this->totalEstimationFeatureJours;
    }

    /**
     * @param int $totalEstimationFeatureJours
     */
    public function setTotalEstimationFeatureJours($totalEstimationFeatureJours)
    {
        $this->totalEstimationFeatureJours = $totalEstimationFeatureJours;
    }

    /**
     * @return int
     */
    public function getStatue()
    {
        return $this->statue;
    }

    /**
     * @param int $statue
     */
    public function setStatue($statue)
    {
        $this->statue = $statue;
    }

    /**
     * @return \Theme
     */
    public function getIdTheme()
    {
        return $this->idTheme;
    }

    /**
     * @param \Theme $idTheme
     */
    public function setIdTheme($idTheme)
    {
        $this->idTheme = $idTheme;
    }

}

