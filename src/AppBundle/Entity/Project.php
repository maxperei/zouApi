<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project", indexes={@ORM\Index(name="fk_project_country1_idx", columns={"country_id"}), @ORM\Index(name="fk_project_group1_idx", columns={"group_id"})})
 * @ORM\Entity
 */
class Project
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="date", nullable=true)
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="dest_country", type="string", length=45, nullable=true)
     */
    private $destCountry;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_date", type="date", nullable=true)
     */
    private $departureDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @var string
     *
     * @ORM\Column(name="accommodation_type", type="string", columnDefinition="ENUM('hotel','apartment','camping')", nullable=true)
     */
    private $accommodationType;

    /**
     * @var string
     *
     * @ORM\Column(name="host_type", type="string", columnDefinition="ENUM('all inclusive','half board','full board','breakfast')", nullable=true)
     */
    private $hostType;

    /**
     * @var integer
     *
     * @ORM\Column(name="discovery_activity", type="integer", nullable=true)
     */
    private $discoveryActivity;

    /**
     * @var integer
     *
     * @ORM\Column(name="lazing_activity", type="integer", nullable=true)
     */
    private $lazingActivity;

    /**
     * @var integer
     *
     * @ORM\Column(name="sport_activity", type="integer", nullable=true)
     */
    private $sportActivity;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximum_budget", type="integer", nullable=true)
     */
    private $maximumBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", length=65535, nullable=true)
     */
    private $config;

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
     * @var \AppBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="project")
     * @ORM\JoinTable(name="project_in_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Project
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set destCountry
     *
     * @param string $destCountry
     * @return Project
     */
    public function setDestCountry($destCountry)
    {
        $this->destCountry = $destCountry;

        return $this;
    }

    /**
     * Get destCountry
     *
     * @return string 
     */
    public function getDestCountry()
    {
        return $this->destCountry;
    }

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     * @return Project
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime 
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     * @return Project
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime 
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * Set accommodationType
     *
     * @param string $accommodationType
     * @return Project
     */
    public function setAccommodationType($accommodationType)
    {
        $this->accommodationType = $accommodationType;

        return $this;
    }

    /**
     * Get accommodationType
     *
     * @return string 
     */
    public function getAccommodationType()
    {
        return $this->accommodationType;
    }

    /**
     * Set hostType
     *
     * @param string $hostType
     * @return Project
     */
    public function setHostType($hostType)
    {
        $this->hostType = $hostType;

        return $this;
    }

    /**
     * Get hostType
     *
     * @return string 
     */
    public function getHostType()
    {
        return $this->hostType;
    }

    /**
     * Set discoveryActivity
     *
     * @param integer $discoveryActivity
     * @return Project
     */
    public function setDiscoveryActivity($discoveryActivity)
    {
        $this->discoveryActivity = $discoveryActivity;

        return $this;
    }

    /**
     * Get discoveryActivity
     *
     * @return integer 
     */
    public function getDiscoveryActivity()
    {
        return $this->discoveryActivity;
    }

    /**
     * Set lazingActivity
     *
     * @param integer $lazingActivity
     * @return Project
     */
    public function setLazingActivity($lazingActivity)
    {
        $this->lazingActivity = $lazingActivity;

        return $this;
    }

    /**
     * Get lazingActivity
     *
     * @return integer 
     */
    public function getLazingActivity()
    {
        return $this->lazingActivity;
    }

    /**
     * Set sportActivity
     *
     * @param integer $sportActivity
     * @return Project
     */
    public function setSportActivity($sportActivity)
    {
        $this->sportActivity = $sportActivity;

        return $this;
    }

    /**
     * Get sportActivity
     *
     * @return integer 
     */
    public function getSportActivity()
    {
        return $this->sportActivity;
    }

    /**
     * Set maximumBudget
     *
     * @param integer $maximumBudget
     * @return Project
     */
    public function setMaximumBudget($maximumBudget)
    {
        $this->maximumBudget = $maximumBudget;

        return $this;
    }

    /**
     * Get maximumBudget
     *
     * @return integer 
     */
    public function getMaximumBudget()
    {
        return $this->maximumBudget;
    }

    /**
     * Set config
     *
     * @param string $config
     * @return Project
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string 
     */
    public function getConfig()
    {
        return $this->config;
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
     * @return Project
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

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     * @return Project
     */
    public function setGroup(\AppBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     * @return Project
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }
}
