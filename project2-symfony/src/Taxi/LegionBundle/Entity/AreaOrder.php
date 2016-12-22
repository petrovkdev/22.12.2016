<?php

namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AreaOrder
 *
 * @ORM\Table(name="lg_area_order")
 * @ORM\Entity(repositoryClass="Taxi\LegionBundle\Repository\AreaOrderRepository")
 */
class AreaOrder
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="adjustment", type="integer", nullable=true)
     */
    private $adjustment;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AreaOrder
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set adjustment
     *
     * @param integer $adjustment
     * @return AreaOrder
     */
    public function setAdjustment($adjustment)
    {
        $this->adjustment = $adjustment;

        return $this;
    }

    /**
     * Get adjustment
     *
     * @return integer 
     */
    public function getAdjustment()
    {
        return $this->adjustment;
    }
}
