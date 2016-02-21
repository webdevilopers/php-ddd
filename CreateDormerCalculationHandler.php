<?php

namespace Sps\Bundle\CalculationBundle\DormerCalculation;

use Sps\Bundle\CalculationBundle\Handler\AbstractCreateCalculationHandler;
use Sps\Bundle\BaseBundle\Entity\DormerCalculation;
use Sps\Bundle\CalculationBundle\Entity\DormerCalculationChargeRate;
use Sps\Bundle\BaseBundle\Entity\DormerCalculationPrice;

class CreateDormerCalculationHandler extends AbstractCreateCalculationHandler
{
    // A lot of traits with a lot of sub-calculations re-used for other calculation types
    use CalculateMounting;
    use CalculateConstructionElement;
    use CalculateConstructionSite;
    use CalculateDelivery;
    use CalculateDormer;
    use CalculateDormerWindow;
    use CalculateDownspout;
    use CalculateGutter;
    use CalculateOverhang;
    
    const WINDOW_DIMENSIONS_ROUNDING_FACTOR = 10;
    
    public function calculate()
    {

    }    