<?php require "lib.megasena.php";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
include "lib.html.head.php";
?>
</head>
<body>
<?php include_once("lib.header.php") ?>

<h2>Todos sorteios</h2>
<?php
// listar últimos jogos
$strSQL = "SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC ";
$resSorteios = $conn->query($strSQL);
while($arSorteio = mysql_fetch_array($resSorteios))
{
	
	echo $arSorteio["jogo"]." : ";
	$strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$arSorteio["jogo"]." ORDER BY num ";
	$resSorteado = $conn->query($strSQL);
	$maiorquarenta = 0;
	$arProximo = $arEste;
	unset($arEste, $nrRepetidos);
	while($arSorteado = mysql_fetch_array($resSorteado))
	{
		
		echo $arSorteado["num"]." ";
		if (in_array($arSorteado["num"], $arProximo))
		{
			$nrRepetidos++;	
		}
		$arEste[] = $arSorteado["num"];
	}
	if ($nrRepetidos >= 4){
			$nrRepetidosQuadra++;
			echo " ======================================= ";
		}
	echo " - $nrRepetidos <br>\n";
}

echo "<h1>Quadras repetidas: $nrRepetidosQuadra </h1>";
?>



<h2>Changelog</h2>
<p>- 2009.03.28 -<br>
Nova regra que exibe os n&uacute;meros que mais sa&iacute;ram nos &uacute;ltimos 10 sorteios.<br>
  Filtro de montagem de n&uacute;meros que elimina os jogos com 3 sequ&ecirc;ncias.</p>
<?php include_once("lib.footer.php"); ?>
</body>
</html>
