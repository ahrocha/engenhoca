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


if (	$_POST["jogoslimitar"] == "jogoslimitar" and is_numeric($_POST["qtdd"]) )
	{
	
	$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos7 ";
	$res = $conn->query($strSQL);
	$total = mysql_result($res, 0, 0);
	
	$frequencia = floor($total/$_POST["qtdd"]);
	$i = 0;
	$linha = 0;
	$strSQL = "SELECT * FROM tbl_SenaJogos7 ORDER BY a, b, c, d, e, f, g ";
	$resJogos = $conn->query($strSQL);
	while($arJogo = mysql_fetch_array($resJogos))
	{
		$i++;
		if ($i == $frequencia)
		{
			//echo $arJogo["a"]." ".$arJogo["b"]." ".$arJogo["c"]." ".$arJogo["d"]." ".$arJogo["e"]." ".$arJogo["f"]."\n";		
			echo fnDoisDigitos($arJogo["a"])." ".fnDoisDigitos($arJogo["b"])." ".fnDoisDigitos($arJogo["c"])." ".fnDoisDigitos($arJogo["d"])." ".fnDoisDigitos($arJogo["e"])." ".fnDoisDigitos($arJogo["f"])." ".fnDoisDigitos($arJogo["g"])." \n";	
			$i = 0;
			$linha++;
			if ($linha==3){echo "<br>\n";$linha = 0;}
		}
	}
}
?>
</pre>
<form method="post">
Jogos: <strong><?php
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos7";
$res = $conn->query($strSQL);
echo mysql_result($res, 0, 0);
?></strong>
<br>
Qtdd de jogos: <input type="text" name="qtdd" value="70">
<br>

  Clique aqui para limitar: <input type="submit" name="jogoslimitar" value="jogoslimitar">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
