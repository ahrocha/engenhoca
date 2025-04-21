<?php

require_once "lib.main.php";
require_once "header.php";

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirJogosLimitar();

include_once("footer.php");
