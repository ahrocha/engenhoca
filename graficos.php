<?php

include_once("header.php");

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirGraficos();

include_once("footer.php");
