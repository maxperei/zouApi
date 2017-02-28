<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * MediaEvent
 *
 * @ORM\Table(name="media_event", indexes={@ORM\Index(name="fk_media_media_event1_idx", columns={"event_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class MediaEvent
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", columnDefinition="ENUM('image','pdf')", nullable=true)
     */
    private $type;

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
     * @var \AppBundle\Entity\Event
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $event;



    /**
     * Set title
     *
     * @param string $title
     * @return MediaEvent
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
     * Set type
     *
     * @param string $type
     * @return MediaEvent
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
     * Set mediaLocation
     *
     * @param string $mediaLocation
     * @return MediaEvent
     */
    public function setMediaLocation($mediaLocation)
    {
        $this->mediaLocation = $mediaLocation;

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
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     * @return MediaEvent
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}
