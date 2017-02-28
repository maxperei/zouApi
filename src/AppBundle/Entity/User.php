<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use JMS\Serializer\Annotation as Serialize;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="`users`", indexes={@ORM\Index(name="fk_user_user_pref1_idx", columns={"user_pref_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=true)
     */
    protected $lastName;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="avatar", fileNameProperty="avatar")
     */
    protected $avatarFile;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\UserPref
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserPref")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_pref_id", referencedColumnName="id")
     * })
     */
    protected $userPref;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", mappedBy="user")
     * @Serialize\MaxDepth(1)
     */
    protected $project;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->project = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set avatarFile
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return User
     */
    public function setAvatarFile(File $file = null)
    {
        $this->avatarFile = $file;
        if($file){
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * Get avatarFile
     *
     * @return File|null
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->avatar;
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
     * Set userPref
     *
     * @param \AppBundle\Entity\UserPref $userPref
     * @return User
     */
    public function setUserPref(\AppBundle\Entity\UserPref $userPref = null)
    {
        $this->userPref = $userPref;

        return $this;
    }

    /**
     * Get userPref
     *
     * @return \AppBundle\Entity\UserPref
     */
    public function getUserPref()
    {
        return $this->userPref;
    }

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     * @return User
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->project[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->project->removeElement($project);
    }

    /**
     * Get project
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProject()
    {
        return $this->project;
    }
}
