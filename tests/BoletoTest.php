<?php
declare (strict_types = 1);

use Boleto\Boleto;
use PHPUnit\Framework\TestCase;

final class BoletoTest extends TestCase
{
    public function testAssertion(): void
    {
        $boleto = Boleto::create('341000000000000000003410000000000044442000005025');
        print("$boleto->value " . $boleto->dueDate->toDateString());
        $this->assertTrue($boleto->isPastDue());
    }
}
