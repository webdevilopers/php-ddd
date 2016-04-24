<?php

namespace Example\Infrastructure\Doctrine;

use Example\Domain\Model\DormerCalculation;
use Example\Domain\Repository\DormerCalculationRepository;

final class DoctrineDormerCalculationRepository implements DormerCalculationRepository
{
    private $object;

    /**
     * @param $id
     *
     * @return object
     */
    public function find($id)
    {
        return $this->object;
    }

    /**
     * @param DormerCalculation $calculation
     */
    public function saveCalculation(DormerCalculation $calculation)
    {
        $this->object = $calculation;
    }
}
