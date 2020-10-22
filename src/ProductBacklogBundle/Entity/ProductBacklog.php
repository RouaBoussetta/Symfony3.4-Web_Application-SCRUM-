<?php

namespace ProductBacklogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductBacklog
 *
 * @ORM\Table(name="product_backlog")
 * @ORM\Entity(repositoryClass="ProductBacklogBundle\Repository\ProductBacklogRepository")
 */
class ProductBacklog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_backlog", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idBacklog;

    /**
     * @var string
     *
     * @ORM\Column(name="ProductBacklog", type="string", length=60, nullable=false)
     */
    private $ProductBacklog;

    /**
     * @return integer
     */
    public function getIdBacklog()
    {
        return $this->idBacklog;
    }

    /**
     * @param int $idBacklog
     */
    public function setIdBacklog($idBacklog)
    {
        $this->idBacklog = $idBacklog;
    }

    /**
     * @return string
     */
    public function getProductBacklog()
    {
        return $this->ProductBacklog;
    }

    /**
     * @param string $ProductBacklog
     */
    public function setProductBacklog($ProductBacklog)
    {
        $this->ProductBacklog = $ProductBacklog;
    }

}

