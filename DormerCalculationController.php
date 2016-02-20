<?php

class DefaultController extends Controller
{
    /**
     * @Route("/calculation/{type}")
     * @Template()
     */
    public function indexAction($type)
    {
        // ... After form process this will be the valid entity
        $dormerCalculation = new DormerCalculation();

        $createDormerCalculationCommand = $this->get('sps.calculation.create_dormer_calculation');
        $createDormerCalculationCommand->setCalculation($dormerCalculation);
        $createDormerCalculationCommand->calculate();
    }
}
