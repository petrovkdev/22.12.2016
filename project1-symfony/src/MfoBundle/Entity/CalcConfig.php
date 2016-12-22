<?php

namespace MfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalcConfig
 *
 * @ORM\Table(name="mfo_calc_config")
 * @ORM\Entity(repositoryClass="MfoBundle\Repository\CalcConfigRepository")
 */
class CalcConfig
{
    /**
     * @var string
     *
     * @ORM\Column(name="name_config", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name_config;

    /**
     * @var int
     *
     * @ORM\Column(name="percent", type="integer")
     */
    private $percent;

    /**
     * @var int
     *
     * @ORM\Column(name="max_summ", type="integer")
     */
    private $maxSumm;

    /**
     * @var int
     *
     * @ORM\Column(name="max_time", type="integer")
     */
    private $maxTime;


    /**
     * Get name_config
     *
     * @return string
     */
    public function getNameConfig()
    {
        return $this->name_config;
    }

    /**
     * Set percent
     *
     * @param integer $percent
     * @return CalcConfig
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return integer 
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set maxSumm
     *
     * @param integer $maxSumm
     * @return CalcConfig
     */
    public function setMaxSumm($maxSumm)
    {
        $this->maxSumm = $maxSumm;

        return $this;
    }

    /**
     * Get maxSumm
     *
     * @return integer 
     */
    public function getMaxSumm()
    {
        return $this->maxSumm;
    }

    /**
     * Set maxTime
     *
     * @param integer $maxTime
     * @return CalcConfig
     */
    public function setMaxTime($maxTime)
    {
        $this->maxTime = $maxTime;

        return $this;
    }

    /**
     * Get maxTime
     *
     * @return integer 
     */
    public function getMaxTime()
    {
        return $this->maxTime;
    }
}
