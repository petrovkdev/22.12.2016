<?php


namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @ORM\Entity
 * @ORM\Table(name="lg_tariffs")
 */
class Tariffs {


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $price_pending;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $price_overdrive;

    /**
     * @ORM\Column(type="integer", length=2)
     */
    private $start_counter;

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
     * @return Tariffs
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
     * Set price
     *
     * @param integer $price
     * @return Tariffs
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price_pending
     *
     * @param integer $pricePending
     * @return Tariffs
     */
    public function setPricePending($pricePending)
    {
        $this->price_pending = $pricePending;

        return $this;
    }

    /**
     * Get price_pending
     *
     * @return integer 
     */
    public function getPricePending()
    {
        return $this->price_pending;
    }

    /**
     * Set price_overdrive
     *
     * @param integer $priceOverdrive
     * @return Tariffs
     */
    public function setPriceOverdrive($priceOverdrive)
    {
        $this->price_overdrive = $priceOverdrive;

        return $this;
    }

    /**
     * Get price_overdrive
     *
     * @return integer 
     */
    public function getPriceOverdrive()
    {
        return $this->price_overdrive;
    }

    /**
     * Set start_counter
     *
     * @param integer $startCounter
     * @return Tariffs
     */
    public function setStartCounter($startCounter)
    {
        $this->start_counter = $startCounter;

        return $this;
    }

    /**
     * Get start_counter
     *
     * @return integer 
     */
    public function getStartCounter()
    {
        return $this->start_counter;
    }


    public function findTariffsAll()
    {
        return $this->repository->findAll();
    }
}
