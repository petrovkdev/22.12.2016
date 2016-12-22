<?php

namespace Site\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsPost
 *
 * @ORM\Table(name="gr_news_post")
 * @ORM\Entity(repositoryClass="Site\BackendBundle\Repository\NewsPostRepository")
 */
class NewsPost
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true, unique=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="media", type="integer", nullable=true)
     */
    private $media;

    /**
     * @var bool
     *
     * @ORM\Column(name="media_anons", type="boolean", nullable=true)
     */
    private $mediaAnons;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var integer
     *
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=60, nullable=true)
     */
    private $autor;

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
     * Set title
     *
     * @param string $title
     * @return NewsPost
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
     * Set autor
     *
     * @param string $autor
     * @return NewsPost
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set media
     *
     * @param integer $media
     * @return NewsPost
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
     * Set body
     *
     * @param string $body
     * @return NewsPost
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return NewsPost
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set category
     *
     * @param integer $category
     * @return NewsPost
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NewsCategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set media_anons
     *
     * @param boolean $mediaAnons
     * @return NewsPost
     */
    public function setMediaAnons($mediaAnons)
    {
        $this->mediaAnons = $mediaAnons;

        return $this;
    }

    /**
     * Get media_anons
     *
     * @return boolean 
     */
    public function getMediaAnons()
    {
        return $this->mediaAnons;
    }
}
