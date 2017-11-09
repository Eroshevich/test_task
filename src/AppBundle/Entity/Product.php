<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblProductData")
 */
class Product
{
    /**
     * @ORM\Column(name="intProductDataId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(name="intProductStock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @ORM\Column(name="numProductCost", type="decimal", nullable=false)
     */
    private $cost;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $productCode;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $dateTimeAdded;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $dateTimeDiscontinued;

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set productCode
     *
     * @param string $productCode
     *
     * @return Product
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set cost
     *
     * @param string $cost
     *
     * @return Product
     */
    public function setPrice($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set dateTimeAdded
     *
     * @param \DateTime $dateTimeAdded
     *
     * @return Product
     */
    public function setDateTimeAdded($dateTimeAdded)
    {
        $this->dateTimeAdded = $dateTimeAdded;

        return $this;
    }

    /**
     * Get dateTimeAdded
     *
     * @return \DateTime
     */
    public function getDateTimeAdded()
    {
        return $this->dateTimeAdded;
    }

    /**
     * Set dateTimeDiscontinued
     *
     * @param \DateTime $dateTimeDiscontinued
     *
     * @return Product
     */
    public function setDateTimeDiscontinued($dateTimeDiscontinued)
    {
        $this->dateTimeDiscontinued = $dateTimeDiscontinued;
        return $this;
    }

    /**
     * Get dateTimeDiscontinued
     *
     * @return \DateTime
     */
    public function getDateTimeDiscontinued()
    {
        return $this->dateTimeDiscontinued;
    }
}