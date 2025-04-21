<?php require "../lib/lib.db.inc.php";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- $Id: htmlquickstart.kmdr,v 1.12 2003/10/04 22:04:17 amantia Exp $ -->
<head>
  <title>teste</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include_once("lib.header.php") ?>
<h2>megasena - combinar</h2>

<?php
$arJogos = array();
//$arNumeros = array(2,5,8,9,13,17,22,44,55);
$arNumeros = array(05,53,51,24,16,23,56,22, 12 );
sort($arNumeros);
$nrDezenas = 6;

function fnNumero($arEscolhidos)
{
//	echo "arEscolhidos:";
//	print_r($arEscolhidos);
//	echo "<br>";
	global $arNumeros, $arJogos, $nrDezenas;
	$arEscolhidosTemp = array();

	$arPossiveis = array_diff($arNumeros, $arEscolhidos);
//print_r( $arPossiveis );
	foreach($arPossiveis as $nrNumero)
	{
		//echo "$nrNumero - ";
		$arEscolhidosTemp = $arEscolhidos;
		$arEscolhidosTemp[] = $nrNumero;
		if (count($arEscolhidosTemp) == $nrDezenas)
		{
			sort($arEscolhidosTemp);
			if (!in_array($arEscolhidosTemp, $arJogos))
			{
				$arJogos[] = $arEscolhidosTemp;
			}
		}else{
			fnNumero($arEscolhidosTemp);
		}
	}
} //

$nivel = 0;
$rodar_arNumeros = $arNumeros;
foreach( $rodar_arNumeros as $numero)
{
	echo "<hr><b>$numero</b><br> ";
	$arEscolhidos = array($numero);
	fnNumero($arEscolhidos);
} // foreach
?>
<p>Jogos: <?php echo sizeof($arJogos); ?></p>
<pre><?php

foreach($arJogos as $arJogo)
{
	foreach($arJogo as $nrNumero)
	{
		echo $nrNumero." ";
	}//foreach
	echo " \n";
} //foreach

?></pre>

<?php include_once("lib.footer.php") ?>
</body>
</html>
