<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Outgo
 *
 * @ORM\Table(name="outgo", indexes={@ORM\Index(name="fk_outgo_outgo_category1_idx", columns={"outgo_category_id"})})
 * @ORM\Entity
 */
class Outgo
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
     * @ORM\Column(name="amount", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_date", type="datetime", nullable=true)
     */
    private $addedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\OutgoCategory
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OutgoCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="outgo_category_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $outgoCategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Budget", inversedBy="outgo")
     * @ORM\JoinTable(name="outgo_in_budget",
     *   joinColumns={
     *     @ORM\JoinColumn(name="outgo_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="budget_id", referencedColumnName="id")
     *   }
     * )
     */
    private $budget;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->budget = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Outgo
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
     * Set amount
     *
     * @param string $amount
     * @return Outgo
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set addedDate
     *
     * @param \DateTime $addedDate
     * @return Outgo
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime 
     */
    public function getAddedDate()
    {
        return $this->addedDate;
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
     * Set outgoCategory
     *
     * @param \AppBundle\Entity\OutgoCategory $outgoCategory
     * @return Outgo
     */
    public function setOutgoCategory(\AppBundle\Entity\OutgoCategory $outgoCategory = null)
    {
        $this->outgoCategory = $outgoCategory;

        return $this;
    }

    /**
     * Get outgoCategory
     *
     * @return \AppBundle\Entity\OutgoCategory 
     */
    public function getOutgoCategory()
    {
        return $this->outgoCategory;
    }

    /**
     * Add budget
     *
     * @param \AppBundle\Entity\Budget $budget
     * @return Outgo
     */
    public function addBudget(\AppBundle\Entity\Budget $budget)
    {
        $this->budget[] = $budget;

        return $this;
    }

    /**
     * Remove budget
     *
     * @param \AppBundle\Entity\Budget $budget
     */
    public function removeBudget(\AppBundle\Entity\Budget $budget)
    {
        $this->budget->removeElement($budget);
    }

    /**
     * Get budget
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBudget()
    {
        return $this->budget;
    }
}
