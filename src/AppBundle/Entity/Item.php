<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table(name="item", indexes={@ORM\Index(name="fk_item_item_category1_idx", columns={"item_category_id"})})
 * @ORM\Entity
 */
class Item
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
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\ItemCategory
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ItemCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_category_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $itemCategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Luggage", mappedBy="item")
     */
    private $luggage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->luggage = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Item
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
     * Set type
     *
     * @param string $type
     * @return Item
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
     * Set quantity
     *
     * @param integer $quantity
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
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
     * Set itemCategory
     *
     * @param \AppBundle\Entity\ItemCategory $itemCategory
     * @return Item
     */
    public function setItemCategory(\AppBundle\Entity\ItemCategory $itemCategory = null)
    {
        $this->itemCategory = $itemCategory;

        return $this;
    }

    /**
     * Get itemCategory
     *
     * @return \AppBundle\Entity\ItemCategory 
     */
    public function getItemCategory()
    {
        return $this->itemCategory;
    }

    /**
     * Add luggage
     *
     * @param \AppBundle\Entity\Luggage $luggage
     * @return Item
     */
    public function addLuggage(\AppBundle\Entity\Luggage $luggage)
    {
        $this->luggage[] = $luggage;

        return $this;
    }

    /**
     * Remove luggage
     *
     * @param \AppBundle\Entity\Luggage $luggage
     */
    public function removeLuggage(\AppBundle\Entity\Luggage $luggage)
    {
        $this->luggage->removeElement($luggage);
    }

    /**
     * Get luggage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLuggage()
    {
        return $this->luggage;
    }
}
