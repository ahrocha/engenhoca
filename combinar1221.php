<?php
require "lib.main.php";

include_once("header.php");

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirCombinar111111();

include_once("footer.php");
