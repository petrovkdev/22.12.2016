<?php

namespace Site\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoDay
 *
 * @ORM\Table(name="gr_photo_day")
 * @ORM\Entity(repositoryClass="Site\BackendBundle\Repository\PhotoDayRepository")
 */
class PhotoDay
{
    /**
     * @var int
     *
     * @ORM\Column(name="name_config", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name_config;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var int
     *
     * @ORM\Column(name="media", type="integer", nullable=true)
     */
    private $media;


    /**
     * Get name_config
     *
     * @return integer 
     */
    public function getNameConfig()
    {
        return $this->name_config;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return PhotoDay
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return PhotoDay
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set media
     *
     * @param integer $media
     * @return PhotoDay
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return integer 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
