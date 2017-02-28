<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table(name="budget", indexes={@ORM\Index(name="fk_budget_project1_idx", columns={"project_id"})})
 * @ORM\Entity
 */
class Budget
{
    /**
     * @var integer
     *
     * @ORM\Column(name="total_amount", type="integer", nullable=true)
     */
    private $totalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $project;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Outgo", mappedBy="budget")
     */
    private $outgo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->outgo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     * @return Budget
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return integer 
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
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
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     * @return Budget
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add outgo
     *
     * @param \AppBundle\Entity\Outgo $outgo
     * @return Budget
     */
    public function addOutgo(\AppBundle\Entity\Outgo $outgo)
    {
        $this->outgo[] = $outgo;

        return $this;
    }

    /**
     * Remove outgo
     *
     * @param \AppBundle\Entity\Outgo $outgo
     */
    public function removeOutgo(\AppBundle\Entity\Outgo $outgo)
    {
        $this->outgo->removeElement($outgo);
    }

    /**
     * Get outgo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOutgo()
    {
        return $this->outgo;
    }
}
