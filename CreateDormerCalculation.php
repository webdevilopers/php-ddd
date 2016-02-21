<?php

namespace Sps\Bundle\CalculationBundle\DormerCalculation;

use Sps\Bundle\CalculationBundle\Entity\DormerCalculation;

class CreateDormerCalculation
{
    public $calculation;

    public function __construct(DormerCalculation $dormerCalculation)
    {
        if (null === $dormerCalculation) {
            throw new \InvalidArgumentException('Missing required "dormerCalculation" parameter');
        }
        $this->calculation = $dormerCalculation;
    }
}
