<?php

use Sps\Bundle\CalculationBundle\Entity\DormerCalculation;
use Sps\Bundle\CalculationBundle\Form\DormerCalculation as CalculationForm;
use Sps\Bundle\CalculationBundle\DormerCalculation\CreateDormerCalculation;

class DefaultController extends Controller
{
    /**
     * @Route("/calculation/{type}")
     * @Template()
     */
    public function indexAction($type)
    {
        // ... After form process this will be the valid entity
        // Validation should be moved from entity to command (=> data_class) instead
        $dormerCalculation = new DormerCalculation();
        
        // @todo Handle form, then populate entity and pass it to command bus and handler

        $createDormerCalculation = new CreateDormerCalculation($dormerCalculation);

        $createDormerCalculationHandler = $this->get('sps.calculation.create_dormer_calculation_handler');
        $createDormerCalculationHandler->handle($createDormerCalculation);
        
        // Get ID from entity and redirect, no return values required
    }
}
