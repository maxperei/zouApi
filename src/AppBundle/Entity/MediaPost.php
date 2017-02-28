<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * MediaPost
 *
 * @ORM\Table(name="media_post", indexes={@ORM\Index(name="fk_media_event1_idx", columns={"post_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class MediaPost
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", columnDefinition="ENUM('photo','video','sound')", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     *
     * @Vich\UploadableField(mapping="media", fileNameProperty="mediaLocation")
     *
     * @var File
     */
    private $mediaFile;

    /**
     * @var string
     *
     * @ORM\Column(name="media_location", type="string", length=255, nullable=true)
     */
    private $mediaLocation;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $post;



    /**
     * Set type
     *
     * @param string $type
     * @return MediaPost
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MediaPost
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
     * Set mediaFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return MediaEvent
     */
    public function setMediaFile($file)
    {
        $this->mediaFile = $file;
    }

    /**
     * Get mediaLocation
     *
     * @return File|null
     */
    public function getMediaFile()
    {
        return $this->mediaFile;
    }

    /**
     * Set location
     *
     * @param string $mediaLocation
     * @return MediaPost
     */
    public function setMediaLocation($mediaLocation)
    {
        $this->location = $mediaLocation;

        return $this;
    }

    /**
     * Get mediaLocation
     *
     * @return string 
     */
    public function getMediaLocation()
    {
        return $this->mediaLocation;
    }

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
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     * @return MediaPost
     */
    public function setPost(\AppBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
