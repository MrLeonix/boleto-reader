<?php

namespace Boleto;

use Boleto\Exception\InvalidNumberLengthException;
use Carbon\Carbon;

/**
 *
 */
class Boleto
{
    const START_REF_DATE = '10/07/1997';

    private $bank;
    private $coin;
    private $dueDate;
    private $number;
    private $value;

    public function __construct()
    {}

    public static function create(string $number): Boleto
    {
        if (strlen($number) < 47 || strlen($number) > 48) {
            throw new InvalidNumberLengthException("Invalid number with " . strlen($number) . " characters. It must have either 47 or 48 characters.");
        }

        $boleto = new Boleto;
        $date = Carbon::create(self::START_REF_DATE);

        $boleto->dueDate = $date->addDays(\intval(\substr($number, 34, 4)));
        $boleto->number = $number;
        $boleto->value = \floatval(\substr($number, 38)) / 100;
        return $boleto;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function isPastDue()
    {
        return Carbon::now() > $this->dueDate;
    }
}
