<?php

include_once("header.php");
require_once "../lib/lib.inc.comum.php";


use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirNumeros();


include_once("footer.php");
