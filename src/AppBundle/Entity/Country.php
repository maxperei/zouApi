<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=45, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=45, nullable=true)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="capital_city", type="string", length=45, nullable=true)
     */
    private $capitalCity;

    /**
     * @var string
     *
     * @ORM\Column(name="jet_lag", type="string", length=15, nullable=true)
     */
    private $jetLag;

    /**
     * @var string
     *
     * @ORM\Column(name="best_period", type="string", length=255, nullable=true)
     */
    private $bestPeriod;

    /**
     * @var integer
     *
     * @ORM\Column(name="flight_duration", type="integer", nullable=true)
     */
    private $flightDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="head_state", type="string", length=45, nullable=true)
     */
    private $headState;

    /**
     * @var float
     *
     * @ORM\Column(name="surface", type="float", precision=10, scale=0, nullable=true)
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(name="inhabitants_name", type="string", length=45, nullable=true)
     */
    private $inhabitantsName;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=true)
     */
    private $population;

    /**
     * @var float
     *
     * @ORM\Column(name="density", type="float", precision=10, scale=0, nullable=true)
     */
    private $density;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_file", type="string", length=255, nullable=true)
     */
    private $flagFile;

    /**
     * @var string
     *
     * @ORM\Column(name="cost_living", type="string", columnDefinition="ENUM('very low','low','regular','expensive','very expensive')", nullable=true)
     */
    private $costLiving;

    /**
     * @var string
     *
     * @ORM\Column(name="adapter", type="string", length=45, nullable=true)
     */
    private $adapter;

    /**
     * @var string
     *
     * @ORM\Column(name="area_code", type="string", length=5, nullable=true)
     */
    private $areaCode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set name
     *
     * @param string $name
     * @return Country
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
     * Set language
     *
     * @param string $language
     * @return Country
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Country
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set capitalCity
     *
     * @param string $capitalCity
     * @return Country
     */
    public function setCapitalCity($capitalCity)
    {
        $this->capitalCity = $capitalCity;

        return $this;
    }

    /**
     * Get capitalCity
     *
     * @return string 
     */
    public function getCapitalCity()
    {
        return $this->capitalCity;
    }

    /**
     * Set jetLag
     *
     * @param string $jetLag
     * @return Country
     */
    public function setJetLag($jetLag)
    {
        $this->jetLag = $jetLag;

        return $this;
    }

    /**
     * Get jetLag
     *
     * @return string 
     */
    public function getJetLag()
    {
        return $this->jetLag;
    }

    /**
     * Set bestPeriod
     *
     * @param string $bestPeriod
     * @return Country
     */
    public function setBestPeriod($bestPeriod)
    {
        $this->bestPeriod = $bestPeriod;

        return $this;
    }

    /**
     * Get bestPeriod
     *
     * @return string 
     */
    public function getBestPeriod()
    {
        return $this->bestPeriod;
    }

    /**
     * Set flightDuration
     *
     * @param integer $flightDuration
     * @return Country
     */
    public function setFlightDuration($flightDuration)
    {
        $this->flightDuration = $flightDuration;

        return $this;
    }

    /**
     * Get flightDuration
     *
     * @return integer 
     */
    public function getFlightDuration()
    {
        return $this->flightDuration;
    }

    /**
     * Set headState
     *
     * @param string $headState
     * @return Country
     */
    public function setHeadState($headState)
    {
        $this->headState = $headState;

        return $this;
    }

    /**
     * Get headState
     *
     * @return string 
     */
    public function getHeadState()
    {
        return $this->headState;
    }

    /**
     * Set surface
     *
     * @param float $surface
     * @return Country
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return float 
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set inhabitantsName
     *
     * @param string $inhabitantsName
     * @return Country
     */
    public function setInhabitantsName($inhabitantsName)
    {
        $this->inhabitantsName = $inhabitantsName;

        return $this;
    }

    /**
     * Get inhabitantsName
     *
     * @return string 
     */
    public function getInhabitantsName()
    {
        return $this->inhabitantsName;
    }

    /**
     * Set population
     *
     * @param integer $population
     * @return Country
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer 
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set density
     *
     * @param float $density
     * @return Country
     */
    public function setDensity($density)
    {
        $this->density = $density;

        return $this;
    }

    /**
     * Get density
     *
     * @return float 
     */
    public function getDensity()
    {
        return $this->density;
    }

    /**
     * Set flagFile
     *
     * @param string $flagFile
     * @return Country
     */
    public function setFlagFile($flagFile)
    {
        $this->flagFile = $flagFile;

        return $this;
    }

    /**
     * Get flagFile
     *
     * @return string 
     */
    public function getFlagFile()
    {
        return $this->flagFile;
    }

    /**
     * Set costLiving
     *
     * @param string $costLiving
     * @return Country
     */
    public function setCostLiving($costLiving)
    {
        $this->costLiving = $costLiving;

        return $this;
    }

    /**
     * Get costLiving
     *
     * @return string 
     */
    public function getCostLiving()
    {
        return $this->costLiving;
    }

    /**
     * Set adapter
     *
     * @param string $adapter
     * @return Country
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get adapter
     *
     * @return string 
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set areaCode
     *
     * @param string $areaCode
     * @return Country
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    /**
     * Get areaCode
     *
     * @return string 
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Country
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
