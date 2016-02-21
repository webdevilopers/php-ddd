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
     * @var string $total
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;    
    
    public function __construct()
    {
      $this->prices = new ArrayCollection();
    }
}
}