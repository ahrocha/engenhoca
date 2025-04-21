<?php

require_once "lib.main.php";
set_time_limit(0);

include_once("header.php");

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirCombinar33();

include_once("footer.php");

exit();
