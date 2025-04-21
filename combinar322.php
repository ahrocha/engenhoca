<?php
require_once "lib.main.php";
set_time_limit(0);

include_once("header.php");

require_once "../lib/lib.inc.comum.php";

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirCombinar322();

include_once("footer.php");
