<?php

namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="lg_orders")
 * @ORM\Entity(repositoryClass="Taxi\LegionBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @ORM\Column(name="phone", type="string", length=12)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="manager", type="integer")
     */
    private $manager;

    /**
     * @var string
     *
     * @ORM\Column(name="street_source", type="string", length=255)
     */
    private $streetSource;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number_source", type="string", length=255, nullable=true)
     */
    private $houseNumberSource;

    /**
     * @var string
     *
     * @ORM\Column(name="street_dest", type="string", length=255, nullable=true)
     */
    private $streetDest;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number_dest", type="string", length=255, nullable=true)
     */
    private $houseNumberDest;

    /**
     * @var int
     *
     * @ORM\Column(name="discount", type="integer")
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer", nullable=true)
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="porch_source", type="integer", nullable=true)
     */
    private $porchSource;

    /**
     * @var int
     *
     * @ORM\Column(name="porch_dest", type="integer", nullable=true)
     */
    private $porchDest;

    /**
     * @var int
     *
     * @ORM\Column(name="driver", type="integer")
     */
    private $driver;

    /**
     * @var int
     *
     * @ORM\Column(name="type_order", type="integer")
     */
    private $typeOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="area", type="integer")
     */
    private $area;

    /**
     * @var bool
     *
     * @ORM\Column(name="child_seat", type="boolean", nullable=true)
     */
    private $childSeat;

    /**
     * @var bool
     *
     * @ORM\Column(name="luggage", type="boolean", nullable=true)
     */
    private $luggage;

    /**
     * @var bool
     *
     * @ORM\Column(name="prior", type="boolean", nullable=true)
     */
    private $prior;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prior_time", type="datetime", nullable=true)
     */
    private $priorTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_order_time", type="datetime")
     */
    private $createOrderTime;


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
     * Set phone
     *
     * @param string $phone
     * @return Orders
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Orders
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set streetSource
     *
     * @param string $streetSource
     * @return Orders
     */
    public function setStreetSource($streetSource)
    {
        $this->streetSource = $streetSource;

        return $this;
    }

    /**
     * Get streetSource
     *
     * @return string 
     */
    public function getStreetSource()
    {
        return $this->streetSource;
    }

    /**
     * Set houseNumberSource
     *
     * @param string $houseNumberSource
     * @return Orders
     */
    public function setHouseNumberSource($houseNumberSource)
    {
        $this->houseNumberSource = $houseNumberSource;

        return $this;
    }

    /**
     * Get houseNumberSource
     *
     * @return string 
     */
    public function getHouseNumberSource()
    {
        return $this->houseNumberSource;
    }

    /**
     * Set streetDest
     *
     * @param string $streetDest
     * @return Orders
     */
    public function setStreetDest($streetDest)
    {
        $this->streetDest = $streetDest;

        return $this;
    }

    /**
     * Get streetDest
     *
     * @return string 
     */
    public function getStreetDest()
    {
        return $this->streetDest;
    }

    /**
     * Set houseNumberDest
     *
     * @param string $houseNumberDest
     * @return Orders
     */
    public function setHouseNumberDest($houseNumberDest)
    {
        $this->houseNumberDest = $houseNumberDest;

        return $this;
    }

    /**
     * Get houseNumberDest
     *
     * @return string 
     */
    public function getHouseNumberDest()
    {
        return $this->houseNumberDest;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     * @return Orders
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

    /**
     * Set total
     *
     * @param integer $total
     * @return Orders
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set childSeat
     *
     * @param boolean $childSeat
     * @return Orders
     */
    public function setChildSeat($childSeat)
    {
        $this->childSeat = $childSeat;

        return $this;
    }

    /**
     * Get childSeat
     *
     * @return boolean 
     */
    public function getChildSeat()
    {
        return $this->childSeat;
    }

    /**
     * Set luggage
     *
     * @param boolean $luggage
     * @return Orders
     */
    public function setLuggage($luggage)
    {
        $this->luggage = $luggage;

        return $this;
    }

    /**
     * Get luggage
     *
     * @return boolean 
     */
    public function getLuggage()
    {
        return $this->luggage;
    }

    /**
     * Set prior
     *
     * @param boolean $prior
     * @return Orders
     */
    public function setPrior($prior)
    {
        $this->prior = $prior;

        return $this;
    }

    /**
     * Get prior
     *
     * @return boolean 
     */
    public function getPrior()
    {
        return $this->prior;
    }

    /**
     * Set priorTime
     *
     * @param \DateTime $priorTime
     * @return Orders
     */
    public function setPriorTime($priorTime)
    {
        $this->priorTime = $priorTime;

        return $this;
    }

    /**
     * Get priorTime
     *
     * @return \DateTime 
     */
    public function getPriorTime()
    {
        return $this->priorTime;
    }

    /**
     * Set createOrderTime
     *
     * @param \DateTime $createOrderTime
     * @return Orders
     */
    public function setCreateOrderTime($createOrderTime)
    {
        $this->createOrderTime = $createOrderTime;

        return $this;
    }

    /**
     * Get createOrderTime
     *
     * @return \DateTime 
     */
    public function getCreateOrderTime()
    {
        return $this->createOrderTime;
    }

    /**
     * Set manager
     *
     * @param integer $manager
     * @return Orders
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return integer 
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set driver
     *
     * @param integer $driver
     * @return Orders
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return integer 
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set porchSource
     *
     * @param integer $porchSource
     * @return Orders
     */
    public function setPorchSource($porchSource)
    {
        $this->porchSource = $porchSource;

        return $this;
    }

    /**
     * Get porchSource
     *
     * @return integer 
     */
    public function getPorchSource()
    {
        return $this->porchSource;
    }

    /**
     * Set porchDest
     *
     * @param integer $porchDest
     * @return Orders
     */
    public function setPorchDest($porchDest)
    {
        $this->porchDest = $porchDest;

        return $this;
    }

    /**
     * Get porchDest
     *
     * @return integer 
     */
    public function getPorchDest()
    {
        return $this->porchDest;
    }

    /**
     * Set typeOrder
     *
     * @param integer $typeOrder
     * @return Orders
     */
    public function setTypeOrder($typeOrder)
    {
        $this->typeOrder = $typeOrder;

        return $this;
    }

    /**
     * Get typeOrder
     *
     * @return integer 
     */
    public function getTypeOrder()
    {
        return $this->typeOrder;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return Orders
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return integer 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
