<?php

/**
 * DormerCalculation
 *
 * @ORM\Entity
 */
class DormerCalculation
{
    // THIS IS ONLY TO MAKE THE PROTOTYPE WORK
    public static $hash;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var DormerCalculationPrice[]
     *
     * @ORM\OneToMany(targetEntity="DormerCalculationPrice",
     *  mappedBy="dormerCalculation", cascade="persist", indexBy="name", fetch="EAGER"
     * )
     */
    private $prices = []; // would need to be ArrayCollection in construct

    public function __construct($unrelevantDependancys = []) // define the required args here
    {
        $this->id = spl_object_hash($this); // FIXME For Prototype only, don't do that
        self::$hash = $this->id;
        // todo $this->prices = new ArrayCollection();
    }

    // FIXME try not the make it public via getter
    public function getId()
    {
        return $this->id;
    }

    public function addPrice($key, $subTotal, $quantity) {
        $price = new DormerCalculationPrice($this, $key, $subTotal, $quantity);
        $this->prices[$key] = $price;
    }

    /**
     * @return DormerCalculationPrice[]
     */
    public function getPrices() // would be better if private or absent, unless absolutly needed
    {
        return $this->prices; // todo should be $this->prices->toArray();
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        $total = 0;
        foreach ($this->prices as $price) {
            $total += $price->getTotal();
        }

        return $total;
    }
}
