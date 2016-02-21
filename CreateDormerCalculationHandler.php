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
        // Do a lot of calculation with values from the entity
        // But since there will be no more getters and setters
        // and not the entity but the command will be data_class
        // of the form and validated should these vars go into
        // the command too (redundant?)?
        // Or only into the command and then set them as valid values on the entity
        // via special method setMeasurements($widht, $height) <- value object?!
        $width = $this->getCalculation()->getWidth();
        $height = $this->getCalculation()->getHeight();
        $quantity = $this->getCalculation()->getQuantity();
        
        // In the end set a lot of prices on the entity
        $total = ($width*$height)*$quantity*1000;
        $this->getCalculation()->addPrice('total', $total);
    }    
}
