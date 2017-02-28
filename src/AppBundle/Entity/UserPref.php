<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPref
 *
 * @ORM\Table(name="user_pref")
 * @ORM\Entity
 */
class UserPref
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="children_number", type="boolean", nullable=true)
     */
    private $childrenNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="relationship", type="boolean", nullable=true)
     */
    private $relationship;

    /**
     * @var string
     *
     * @ORM\Column(name="accomodation_type", type="string", length=45, nullable=true)
     */
    private $accomodationType;

    /**
     * @var string
     *
     * @ORM\Column(name="activity_type", type="string", columnDefinition="ENUM('discovery','relax','sport')", nullable=true)
     */
    private $activityType;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set childrenNumber
     *
     * @param boolean $childrenNumber
     * @return UserPref
     */
    public function setChildrenNumber($childrenNumber)
    {
        $this->childrenNumber = $childrenNumber;

        return $this;
    }

    /**
     * Get childrenNumber
     *
     * @return boolean 
     */
    public function getChildrenNumber()
    {
        return $this->childrenNumber;
    }

    /**
     * Set relationship
     *
     * @param boolean $relationship
     * @return UserPref
     */
    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * Get relationship
     *
     * @return boolean 
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * Set accomodationType
     *
     * @param string $accomodationType
     * @return UserPref
     */
    public function setAccomodationType($accomodationType)
    {
        $this->accomodationType = $accomodationType;

        return $this;
    }

    /**
     * Get accomodationType
     *
     * @return string 
     */
    public function getAccomodationType()
    {
        return $this->accomodationType;
    }

    /**
     * Set activityType
     *
     * @param string $activityType
     * @return UserPref
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * Get activityType
     *
     * @return string 
     */
    public function getActivityType()
    {
        return $this->activityType;
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
}
