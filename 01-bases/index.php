<?php

require_once __DIR__ . '/vendor/autoload.php';

use Cocur\Slugify\Slugify;
use Presentation\Compta\Employe as RhEmploye;

$slugger = new Slugify();
$slug  = $slugger->slugify('Le slug c\'est super');

var_dump($slug);

$employe = new RhEmploye('Damien', 'Valade',25);
$employe->presentation();