<?php

namespace Sps\Bundle\CalculationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DormerCalculation
 *
 * @ORM\Entity
 */
class DormerCalculation
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string $quantity
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string $height
     *
     * @ORM\Column(name="h", type="float")
     */
    private $height;

    /**
     * @var string $width
     *
     * @ORM\Column(name="w", type="float")
     */
    private $width;    

    /**
     * @ORM\OneToMany(targetEntity="DormerCalculationPrice",
     *  mappedBy="dormerCalculation", cascade="persist", indexBy="name", fetch="EAGER"
     * )
     */
    private $prices;    
    
    public function __construct($lotsOfValues)
    {
        // Do not use getters and setters on entity, put all vars here via constructor
        // or method e.g. addPrice() ?!
        
        // Use a single $lotsOfValues var if there are a lot?!
                
    }
    
    public function addPrice(DormerCalculationPrice $price) {
        $this->prices[$price->getName()] = $price;
        $price->setDormerCalculation($this);
    }    
}
