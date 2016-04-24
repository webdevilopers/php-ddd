<?php

namespace Example\Domain;

use Example\Domain\Model\Identity\CalculationId;

interface DormerIdentityGenerator
{
    /**
     * @return CalculationId
     */
    public function generateDormerIdentity();
}
