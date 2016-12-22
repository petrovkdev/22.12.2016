<?php

namespace MfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteSettings
 *
 * @ORM\Table(name="mfo_site_settings")
 * @ORM\Entity(repositoryClass="MfoBundle\Repository\SiteSettingsRepository")
 */
class SiteSettings
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=100, nullable=true)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="text", nullable=true)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=100, nullable=true)
     */
    private $logo;

    /**
     * @var bool
     *
     * @ORM\Column(name="robots", type="boolean", options={"default"=0})
     */
    private $robots;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="favicon", type="string", length=100, nullable=true)
     */
    private $favicon;

    /**
     * @var bool
     *
     * @ORM\Column(name="maintenance", type="boolean", options={"default"=0})
     */
    private $maintenance;


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
     * Set title
     *
     * @param string $title
     * @return SiteSettings
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return SiteSettings
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string 
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return SiteSettings
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return SiteSettings
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return SiteSettings
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set robots
     *
     * @param boolean $robots
     * @return SiteSettings
     */
    public function setRobots($robots)
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * Get robots
     *
     * @return boolean
     */
    public function getRobots()
    {
        return $this->robots;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return SiteSettings
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
     * @return SiteSettings
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
     * Set favicon
     *
     * @param string $favicon
     * @return SiteSettings
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;

        return $this;
    }

    /**
     * Get favicon
     *
     * @return string 
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * Set maintenance
     *
     * @param boolean $maintenance
     * @return SiteSettings
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return boolean 
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }
}
