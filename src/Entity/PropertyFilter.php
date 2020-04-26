<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyFilter
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $options;


    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * Get the value of maxPrice
     * @return  int|null
     */ 
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     * @param  int|null  $maxPrice
     * @return PropertyFilter
     */
    public function setMaxPrice(int $maxPrice) : PropertyFilter
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get the value of minSurface
     * @return  int|null
     */ 
    public function getMinSurface() : ?int
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     * @param  int|null  $minSurface
     * @return PropertyFilter
     */ 
    public function setMinSurface(int $minSurface) : PropertyFilter
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * Get the value of options
     *
     * @return  ArrayCollection
     */ 
    public function getOptions() : ArrayCollection
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param  ArrayCollection  $options
     */ 
    public function setOptions(ArrayCollection $options) : void
    {
        $this->options = $options;

    }
} 