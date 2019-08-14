<?php

declare(strict_types=1);

use Boleto\Bank;
use Boleto\Exception\NoBankFoundForProvidedCodeException;
use PHPUnit\Framework\TestCase;

final class BankTest extends TestCase
{
    public function testInvalidBankCode()
    {
        $this->expectException(NoBankFoundForProvidedCodeException::class);

        $bank = new Bank('');
    }
}
