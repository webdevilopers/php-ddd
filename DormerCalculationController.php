<?php

class DefaultController extends Controller
{
    /**
     * @Route("/calculation/{type}")
     * @Template()
     */
    public function indexAction($type)
    {
        $data = $this->getRequest()->request->all();

        // Generate calculation only - no prices!
        $dormerCalculation = new DormerCalculation();

        $createDormerCalculationCommand = $this->get('sps.calculation.create_dormer_calculation');
        $createDormerCalculationCommand->setCalculation($dormerCalculation);
        $createDormerCalculationCommand->calculate($data);
    }
}
