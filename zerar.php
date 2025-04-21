<?php


include_once("header.php");


use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirZerar();


?>

<?php include_once("footer.php"); ?>