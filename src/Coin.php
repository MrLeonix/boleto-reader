<?php

namespace Boleto;

use Boleto\Exception\NoCoinFoundForProvidedCodeException;

/**
 * 
 */
class Coin
{
    private $code;
    private $name;

    public function __construct(string $code)
    {
        $coins = include(__DIR__ . '/../config/coins.php');
        if (!isset($coins[$code])) throw new NoCoinFoundForProvidedCodeException("There is no coin under code ${code}.");

        foreach ($coins[$code] as $key => $value) $this->$key = $value;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
