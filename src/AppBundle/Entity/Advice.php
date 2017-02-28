<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Advice
 *
 * @ORM\Table(name="advice", indexes={@ORM\Index(name="fk_advice_country1_idx", columns={"country_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Advice
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", columnDefinition="ENUM('health & safety','practical life','various')", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

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
     * @var \AppBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $country;



    /**
     * Set type
     *
     * @param string $type
     * @return Advice
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
     * Set name
     *
     * @param string $name
     * @return Advice
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
     * Set content
     *
     * @param string $content
     * @return Advice
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
     * Set advice
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return Advice
     */
    public function setMediaFile(File $file = null)
    {
        $this->mediaFile = $file;
    }

    /**
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
     * @return Advice
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
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     * @return Advice
     */
    public function setCountry(\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
