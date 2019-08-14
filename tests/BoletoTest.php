<?php

declare(strict_types=1);

use Boleto\Bank;
use Boleto\Boleto;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

final class BoletoTest extends TestCase
{
    const BANK_BOLETO_NUMBER = '34190.00000 00000.000003 41000.000000 0 44442000005025';
    const DEALERSHIP_BOLETO_NUMBER = '84670000001-7 43590024020-9 02405000243-5 84221010811-9';
    const PAST_DUE_BANK_BOLETO_NUMBER = '34190.00000 00000.000003 41000.000000 0 00002000005025';

    public function testValidNumberLength(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $boletoNumberLength = strlen($boleto->number);

        $this->assertTrue($boletoNumberLength === 47);

        $boleto = Boleto::create(self::DEALERSHIP_BOLETO_NUMBER);

        $boletoNumberLength = strlen($boleto->number);

        $this->assertTrue($boletoNumberLength === 48);
    }

    public function testNoEmptyFields(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertNotNull($boleto->bank);
        $this->assertNotNull($boleto->coin);
        $this->assertNotNull($boleto->dueDate);
        $this->assertNotNull($boleto->number);
        $this->assertNotNull($boleto->type);
        $this->assertNotNull($boleto->value);

        $boleto = Boleto::create(self::DEALERSHIP_BOLETO_NUMBER);

        $this->assertNotNull($boleto->number);
        $this->assertNotNull($boleto->type);
        $this->assertNotNull($boleto->value);
    }

    public function testBankMatchesNumber(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertEquals($boleto->bank->code, '341');
        $this->assertEquals($boleto->bank->name, 'Banco Itaú S.A.');
    }

    public function testCoinMatchesNumber(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertEquals($boleto->coin->code, 9);
        $this->assertEquals($boleto->coin->name, 'BRL');
    }

    public function testDueDateMatchesNumber(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertEquals($boleto->dueDate, Carbon::create(Boleto::START_REF_DATE)->addDays(4444));
    }

    public function testNumberMatchesNumber(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertEquals($boleto->number, '34190000000000000000341000000000044442000005025');

        $boleto = Boleto::create(self::DEALERSHIP_BOLETO_NUMBER);

        $this->assertEquals($boleto->number, '846700000017435900240209024050002435842210108119');
    }

    public function testValueMatchesNumber(): void
    {
        $boleto = Boleto::create(self::BANK_BOLETO_NUMBER);

        $this->assertEquals($boleto->value, 20000050.25);

        $boleto = Boleto::create(self::DEALERSHIP_BOLETO_NUMBER);

        $this->assertEquals($boleto->value, 143.59);
    }

    public function testBoletoIsPastDue()
    {
        $boleto = Boleto::create(self::PAST_DUE_BANK_BOLETO_NUMBER);

        $this->assertTrue($boleto->isPastDue());
    }
}