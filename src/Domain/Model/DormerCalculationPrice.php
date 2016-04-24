<?php

namespace Example\Domain\Model;

class DormerCalculationPrice
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $subtotal;

    /**
     * @var DormerCalculation
     */
    private $calculation;

    /**
     * @param DormerCalculation $calculation
     * @param $name
     * @param $subTotal
     * @param $quantity
     *
     * I suggest to pass not nullable relations in construct, and not provide setters
     * for attribute that don't chance or cannot be changed in the domain
     */
    public function __construct(DormerCalculation $calculation, $name, $subTotal, $quantity)
    {
        $this->calculation = $calculation;
        $this->name = $name;
        $this->subtotal = $subTotal;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function calculateTotal()
    {
        return $this->subtotal * $this->quantity;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
