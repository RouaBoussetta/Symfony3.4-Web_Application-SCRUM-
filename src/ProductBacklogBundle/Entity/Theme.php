<?php

namespace ProductBacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;



/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="ProductBacklogBundle\Repository\ThemeRepository")
 */
class Theme
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_theme", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     *
     */
    private $idTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_theme", type="string", length=50, nullable=false)
     *
     */
    private $nomTheme;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_estimation_theme_jours", type="integer", nullable=false)
     *
     */
    private $totalEstimationThemeJours = '0';

    /**
     * @var \ProductBacklog
     *
     * @ORM\ManyToOne(targetEntity="ProductBacklog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_backlog", referencedColumnName="id_backlog")
     * })
     */
    private $idBacklog;

    /**
     * @return int
     */
    public function getIdTheme()
    {
        return $this->idTheme;
    }

    /**
     * @param int $idTheme
     */
    public function setIdTheme($idTheme)
    {
        $this->idTheme = $idTheme;
    }

    /**
     * @return string
     */
    public function getNomTheme()
    {
        return $this->nomTheme;
    }

    /**
     * @param string $nomTheme
     */
    public function setNomTheme($nomTheme)
    {
        $this->nomTheme = $nomTheme;
    }

    /**
     * @return int
     */
    public function getTotalEstimationThemeJours()
    {
        return $this->totalEstimationThemeJours;
    }

    /**
     * @param int $totalEstimationThemeJours
     */
    public function setTotalEstimationThemeJours($totalEstimationThemeJours)
    {
        $this->totalEstimationThemeJours = $totalEstimationThemeJours;
    }

    /**
     * @return \ProductBacklog
     */
    public function getIdBacklog()
    {
        return $this->idBacklog;
    }

    /**
     * @param \ProductBacklog $idBacklog
     */
    public function setIdBacklog($idBacklog)
    {
        $this->idBacklog = $idBacklog;
    }

}

