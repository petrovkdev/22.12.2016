<?php

namespace Taxi\LegionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="lg_config")
 * @ORM\Entity(repositoryClass="Taxi\LegionBundle\Repository\ConfigRepository")
 */
class Config
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="tariff", type="integer", nullable=true)
     */
    private $tariff;

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
     * Set tariff
     *
     * @param integer $tariff
     * @return Config
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * Get tariff
     *
     * @return integer 
     */
    public function getTariff()
    {
        return $this->tariff;
    }

}
