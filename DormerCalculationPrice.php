<?php

class DormerCalculationPrice
{
    private $name;
    private $quantity;
    private $total;
    private $subtotal;
    private $calculation; // probably not transferable??? so no set once created

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
        $this->total = $this->calculateTotal();
    }

    /**
     * @return int
     */
    private function calculateTotal()
    {
        return $this->subtotal * $this->quantity; //The result of your calculation
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
    // setter should be necessary here only for attribute that can change over the life cycle of the entity
}
