<?php

namespace Sps\Bundle\CalculationBundle\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;
use Sps\Bundle\CalculationBundle\Entity\DormerCalculationPrice;

abstract class AbstractCreateCalculationHandler
{
    const DECIMALS = 2;

    private $entityManager;

    private $tokenStorage;

    private $session;

    private $translator;

    protected $translationDomain;

    protected $calculation;

    private $variables;

    public function __construct(EntityManager $entityManager, TokenStorageInterface $tokenStorage, Session $session, Translator $translator)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->translator = $translator;
    }

    public function handle($command)
    {
        $this->calculation = $command->calculation;
        $this->calculate();
        $this->save();
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function getTokenStorage() {
        return $this->tokenStorage;
    }

    public function getSession() {
        return $this->session;
    }

    public function getTranslator() {
        return $this->translator;
    }

    public function getTranslationDomain() {
        return $this->translationDomain;
    }

    public function getCalculation() {
        return $this->calculation;
    }

    public function getPartner()
    {
        return $this->getEntityManager()
            ->getRepository('SpsBaseBundle:Partner')
            ->find($this->getTokenStorage()->getToken()->getUser()->getId());
    }

    /**
     *
     * @param type $message
     * @param array $parameters
     * @param type $type
     */
    public function addMessage($message, array $parameters = array(), $type = 'notice')
    {
        // bootstrap: notice, error / warning, success
        $this->session->getFlashBag()->add(
            $type, $this->translator
                ->trans($message, $parameters, $this->getTranslationDomain()));
    }

    public function getMessages()
    {
        return $this->session->getFlashBag()->all();
    }

    public function getVariables() {
        return $this->variables;
    }

    public function getVariable($key)
    {
        if (!isset($this->variables[$key])) {
            throw new \InvalidArgumentException("Variable `$key` does not exist.");
        }

        return $this->variables[$key];
    }

    public function hasVariable($key)
    {
        return isset($this->variables[$key]) ? true : false;
    }

    public function setVariable($key, $value)
    {
        $this->variables[$key] = $value;
    }

    public function getPrice($key)
    {
        return $this->calculation->getPrice($key);
    }

    public function hasPrice($key)
    {
        return $this->calculation->hasPrice($key);
    }

    public function setPrice($key, $value)
    {
        $this->calculation->setPrice($key, $value);
    }

    public function addPrice($key, $subtotal, $quantity = 1, $showInOffer = false)
    {
        $total = $subtotal*$quantity;

        $dormerCalculationPrice = new DormerCalculationPrice;
        $dormerCalculationPrice->setName($key);
        $dormerCalculationPrice->setValue($subtotal);
        $dormerCalculationPrice->setQuantity($quantity);
        $dormerCalculationPrice->setTotal($total);
        $dormerCalculationPrice->setShowInOffer($showInOffer);
        $this->getCalculation()->addPrice($dormerCalculationPrice);
    }

    private function round($price)
    {
        return round($price, self::DECIMALS);
    }
    
    protected function save()
    {
        $this->getEntityManager()->persist($this->getCalculation());
        $this->getEntityManager()->flush();
    }
}
