<?php

include_once("header.php");

use App\Controllers\MegasenaController;

$controller = new MegasenaController();
$controller->exibirInicio();

?>
<?php include_once("footer.php"); ?>
</body>
</html>
