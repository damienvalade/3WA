<?php

require __DIR__ . '\vendor\autoload.php';

use App\Taxes\TaxeCalculator;

$calculator = new TaxeCalculator();
$calcul = $calculator->calculate(20,10000,10);
var_dump($calcul);