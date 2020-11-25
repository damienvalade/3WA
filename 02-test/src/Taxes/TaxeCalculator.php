<?php

namespace App\Taxes;

class TaxeCalculator
{

    public function calculate(int $age, int $salary, float $rate): float
    {
        $result = ($salary * ($rate/100)) / $age;
        return $result;
    }

}