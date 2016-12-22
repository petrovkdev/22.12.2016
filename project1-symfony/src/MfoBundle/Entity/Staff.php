<?php

namespace MfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Staff
 *
 * @ORM\Table(name="mfo_staff")
 * @ORM\Entity(repositoryClass="MfoBundle\Repository\StaffRepository")
 */
class Staff
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
     * @ORM\Column(name="user_name", type="string", length=100, nullable=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=60, nullable=true)
     */
    private $position;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=155, nullable=true)
     */
    private $phone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="educate", type="string", length=155, nullable=true)
     */
    private $educate;

    /**
     * @var int
     *
     * @ORM\Column(name="media", type="integer", nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
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
     * Set userName
     *
     * @param string $userName
     * @return Staff
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Staff
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * Set phone
     *
     * @param string $phone
     * @return Staff
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
     * Set educate
     *
     * @param string $educate
     * @return Staff
     */
    public function setEducate($educate)
    {
        $this->educate = $educate;

        return $this;
    }

    /**
     * Get educate
     *
     * @return string 
     */
    public function getEducate()
    {
        return $this->educate;
    }

    /**
     * Set media
     *
     * @param integer $media
     * @return Staff
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

    /**
     * Set description
     *
     * @param string $description
     * @return Staff
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
     * Set seq_number
     *
     * @param integer $seqNumber
     * @return Staff
     */
    public function setSeqNumber($seqNumber)
    {
        $this->seq_number = $seqNumber;

        return $this;
    }

    /**
     * Get seq_number
     *
     * @return integer 
     */
    public function getSeqNumber()
    {
        return $this->seq_number;
    }
}
