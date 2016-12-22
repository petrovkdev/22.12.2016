<?php

namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discount
 *
 * @ORM\Table(name="lg_discount")
 * @ORM\Entity(repositoryClass="Taxi\LegionBundle\Repository\DiscountRepository")
 */
class Discount
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
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="travel", type="string", length=100, nullable=true)
     */
    private $travel;

    /**
     * @var int
     *
     * @ORM\Column(name="abonent", type="integer", nullable=true)
     */
    private $abonent;

    /**
     * @var int
     *
     * @ORM\Column(name="discount", type="integer")
     */
    private $discount;


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
     * @return Discount
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
     * Set travel
     *
     * @param string $travel
     * @return Discount
     */
    public function setTravel($travel)
    {
        $this->travel = $travel;

        return $this;
    }

    /**
     * Get travel
     *
     * @return string 
     */
    public function getTravel()
    {
        return $this->travel;
    }

    /**
     * Set abonent
     *
     * @param integer $abonent
     * @return Discount
     */
    public function setAbonent($abonent)
    {
        $this->abonent = $abonent;

        return $this;
    }

    /**
     * Get abonent
     *
     * @return integer 
     */
    public function getAbonent()
    {
        return $this->abonent;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     * @return Discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer 
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
