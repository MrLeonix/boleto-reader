<?php

namespace Boleto;

use Boleto\Exception\InvalidNumberLengthException;
use Boleto\Exception\InvalidNumberException;
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
    private $type;
    private $value;

    public function __construct()
    { }

    public static function create(string $number): Boleto
    {
        if (empty($number)) throw new InvalidNumberException("Cannot create a Boleto with empty number.");
        $number = preg_replace("/[\.\s\-]/", "", $number);
        $boletoNumberLength = strlen($number);
        $boleto = new Boleto;

        if($boletoNumberLength === 47) $boleto->type = BoletoType::BANK;
        else if($boletoNumberLength === 48) $boleto->type = BoletoType::DEALERSHIP;
        else throw new InvalidNumberLengthException("Invalid number with ${boletoNumberLength} characters. It must have either 47 or 48 characters.");
        
        $date = Carbon::create(self::START_REF_DATE);

        if($boleto->type === BoletoType::BANK){
            $boleto->bank = new Bank(\substr($number, 0, 3));
            $boleto->coin = new Coin(\substr($number, 3, 1));
            $boleto->dueDate = $date->addDays(\intval(\substr($number, 33, 4)));
            $boleto->number = $number;
            $boleto->value = \floatval(\substr($number, 37)) / 100;
        } else {
            $boleto->number = $number;
            $boleto->value = \floatval(\substr($number, 4, 7) . \substr($number, 12, 4)) / 100;
        }
        
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
