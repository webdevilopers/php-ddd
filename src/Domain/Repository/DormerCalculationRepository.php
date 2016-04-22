<?php

namespace Example\Domain\Repository;

use Example\Domain\Model\DormerCalculation;

interface DormerCalculationRepository
{
    /**
     * @param DormerCalculation $calculation
     */
    public function saveCalculation(DormerCalculation $calculation);
}
