<?php
require_once __DIR__."/vendor/autoload.php";

use App\App;

if(count($argv) != 3) {
    echo "Bad params\n";
    exit();
}

$app = new App($argv[1], __DIR__."/people.csv", __DIR__."/texts");
$app->execute($argv[2]);