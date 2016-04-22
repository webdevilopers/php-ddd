<?php

namespace Example\Infrastructure;

use Example\Domain\DormerIdentityGenerator;
use Example\Domain\Model\Identity\CalculationId;

final class UniqueIdGenerator implements DormerIdentityGenerator
{
    /**
     * @return CalculationId
     */
    public function generateDormerIdentity()
    {
        return new CalculationId(uniqid());
    }
}
