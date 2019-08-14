<?php

declare(strict_types=1);

use Boleto\Coin;
use Boleto\Exception\NoCoinFoundForProvidedCodeException;
use PHPUnit\Framework\TestCase;

final class CoinTest extends TestCase
{
    public function testInvalidCoinCode()
    {
        $this->expectException(NoCoinFoundForProvidedCodeException::class);
        
        $bank = new Coin('');
    }
}
