<?php

namespace MfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 *
 * @ORM\Table(name="mfo_services")
 * @ORM\Entity(repositoryClass="MfoBundle\Repository\ServicesRepository")
 */
class Services
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="media_id", type="integer", length=11)
     */
    private $media_id;
    
    /**
     * @var int
     *
     * @ORM\Column(name="gallery", type="integer", length=11)
     */
    private $gallery;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="seq_number", type="integer")
     */
    private $seq_number;


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
     * @return Services
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
     * Set gallery
     *
     * @param integer $gallery
     * @return Services
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return integer
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set media_id
     *
     * @param integer $media_id
     * @return Services
     */
    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;

        return $this;
    }

    /**
     * Get media_id
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Services
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set seq_number
     *
     * @param integer $seq_number
     * @return Services
     */
    public function setSeqNumber($seq_number)
    {
        $this->seq_number = $seq_number;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getSeqNumber()
    {
        return $this->seq_number;
    }
}
