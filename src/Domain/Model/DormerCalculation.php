<?php

namespace Example\Domain\Model;

use Example\Domain\Model\Identity\CalculationId;

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
     * @var DormerCalculationPrice[]
     *
     * @ORM\OneToMany(targetEntity="DormerCalculationPrice",
     *  mappedBy="dormerCalculation", cascade="persist", indexBy="name", fetch="EAGER"
     * )
     */
    private $prices = [];

    public function __construct(CalculationId $id)
    {
        $this->id = $id->id();
    }

    /**
     * @return CalculationId
     */
    public function getIdentity()
    {
        return new CalculationId($this->id);
    }

    /**
     * @param string $name
     * @param int $subTotal
     * @param int $quantity
     *
     * @return DormerCalculationPrice
     */
    public function addPrice($name, $subTotal, $quantity) {
        $price = new DormerCalculationPrice($this, $name, $subTotal, $quantity);
        $this->prices[$name] = $price;

        return $price;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        $total = 0;
        foreach ($this->prices as $price) {
            $total += $price->calculateTotal();
        }

        return $total;
    }
}
