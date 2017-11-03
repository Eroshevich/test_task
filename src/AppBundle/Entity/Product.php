<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tblProductData")
 */
class Product
{

    /**
     * @ORM\Column(type="integer")
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
     * @ORM\Column(name="intProductStock", type="integer", length=50, nullable=false)
     */
    private $stock;

    /**
     * @ORM\Column(name="numProductCost", type="decimal", length=50, nullable=false)
     */
    private $cost;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $productCode;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $dateTimeAdded;

    /**
     * @ORM\Column(name="dtmDiscounted", type="datetime", nullable=true)
     */
    private $dateTimeDiscontinued;

    /**
     * @ORM\Column(name="stmTimestamp", type="integer", nullable=false)
     */
    private $timestamp;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param mixed $productCode
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateTimeAdded()
    {
        return $this->dateTimeAdded;
    }

    /**
     * @param mixed $dateTimeAdded
     */
    public function setDateTimeAdded($dateTimeAdded)
    {
        $this->dateTimeAdded = $dateTimeAdded;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateTimeDiscontinued()
    {
        return $this->dateTimeDiscontinued;
    }

    /**
     * @param mixed $dateTimeDiscontinued
     */
    public function setDateTimeDiscontinued($dateTimeDiscontinued)
    {
        $this->dateTimeDiscontinued = $dateTimeDiscontinued;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

}