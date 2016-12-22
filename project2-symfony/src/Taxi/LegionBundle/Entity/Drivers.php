<?php

namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drivers
 *
 * @ORM\Table(name="lg_drivers")
 * @ORM\Entity(repositoryClass="Taxi\LegionBundle\Repository\DriversRepository")
 */
class Drivers
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
     * @var int
     *
     * @ORM\Column(name="driver_call", type="integer", unique=true)
     */
    private $driverCall;

    /**
     * @var string
     *
     * @ORM\Column(name="driver_machine", type="string", length=100, unique=true)
     */
    private $driverMachine;

    /**
     * @var string
     *
     * @ORM\Column(name="machine_marka", type="string", length=50)
     */
    private $machineMarka;

    /**
     * @var string
     *
     * @ORM\Column(name="machine_color", type="string", length=50)
     */
    private $machineColor;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;


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
     * @return Drivers
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
     * Set driverCall
     *
     * @param integer $driverCall
     * @return Drivers
     */
    public function setDriverCall($driverCall)
    {
        $this->driverCall = $driverCall;

        return $this;
    }

    /**
     * Get driverCall
     *
     * @return integer 
     */
    public function getDriverCall()
    {
        return $this->driverCall;
    }

    /**
     * Set driverMachine
     *
     * @param string $driverMachine
     * @return Drivers
     */
    public function setDriverMachine($driverMachine)
    {
        $this->driverMachine = $driverMachine;

        return $this;
    }

    /**
     * Get driverMachine
     *
     * @return string 
     */
    public function getDriverMachine()
    {
        return $this->driverMachine;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Drivers
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Drivers
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
     * Set machineMarka
     *
     * @param string $machineMarka
     * @return Drivers
     */
    public function setMachineMarka($machineMarka)
    {
        $this->machineMarka = $machineMarka;

        return $this;
    }

    /**
     * Get machineMarka
     *
     * @return string 
     */
    public function getMachineMarka()
    {
        return $this->machineMarka;
    }

    /**
     * Set machineColor
     *
     * @param string $machineColor
     * @return Drivers
     */
    public function setMachineColor($machineColor)
    {
        $this->machineColor = $machineColor;

        return $this;
    }

    /**
     * Get machineColor
     *
     * @return string 
     */
    public function getMachineColor()
    {
        return $this->machineColor;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Drivers
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
}
