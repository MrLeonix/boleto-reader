<?php

namespace Boleto;

use Boleto\Exception\NoBankFoundForProvidedCodeException;

/**
 * 
 */
class Bank
{
    private $code;
    private $name;

    public function __construct(string $code)
    {
        $banks = include(__DIR__ . '/../config/banks.php');
        if (!isset($banks[$code])) throw new NoBankFoundForProvidedCodeException("There is no bank under code ${code}.");

        foreach ($banks[$code] as $key => $value) $this->$key = $value;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
