<?php
require "lib.main.php";
$nrExcluidos = 0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- $Id: htmlquickstart.kmdr,v 1.12 2003/10/04 22:04:17 amantia Exp $ -->
<head>
<?php
include "lib.html.head.php";
?>
</head>
<body>
<?php include_once("lib.header.php") ?>
<pre>
<?php


if (	$_POST["todosjogos"] == "todosjogos" )
	{
	$strSQL = "SELECT * FROM tbl_SenaJogos ORDER BY a, b, c, d, e, f";
	$resJogos = $conn->query($strSQL);
	echo mysql_error();
	while($arJogo = mysql_fetch_array($resJogos))
	{
		echo fnDoisDigitos($arJogo["a"])." ".fnDoisDigitos($arJogo["b"])." ".fnDoisDigitos($arJogo["c"])." ".fnDoisDigitos($arJogo["d"])." ".fnDoisDigitos($arJogo["e"])." ".fnDoisDigitos($arJogo["f"])." \n";		
	}
}
?>
</pre>
<form method="post">
Jogos: <strong><?php
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos";
$res = $conn->query($strSQL);
echo mysql_result($res, 0, 0);
?></strong>
<br>
  Clique aqui para exibir todos os jogos: <input type="submit" name="todosjogos" value="todosjogos">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
