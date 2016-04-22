<?php

namespace Example\Infrastructure\CQRS\Command;

/**
 * This class is used as date_class in form component
 */
class CalculationCommand
{
    const BASIC_TYPE = 'basic_calculaction_type';

    public $subTotal;
    public $quantity;
}
