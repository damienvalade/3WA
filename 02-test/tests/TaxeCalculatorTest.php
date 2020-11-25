<?php


use App\Taxes\TaxeCalculator;
use PHPUnit\Framework\TestCase;

class TaxeCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        $calculator = new TaxeCalculator();
        $calcul = $calculator->calculate(20,10000,10);
        $this->assertEquals('50',$calcul);
    }
}