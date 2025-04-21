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



if ($_POST["validar"] == "sim" )
{
	$strSQL = "SELECT * FROM tbl_SenaJogos8 WHERE media = 0 LIMIT 10000";	
	$resJogos = $conn->query($strSQL);
	echo "\nJogos: ".mysql_num_rows($resJogos);
	while ($arJogo = mysql_fetch_array($resJogos))
	{
			$nrPares = 0;
			//print_r($arJogo);
			$nrSoma = $arJogo["a"] + $arJogo["b"] + $arJogo["c"] + $arJogo["d"] + $arJogo["e"] + $arJogo["f"] + $arJogo["g"] + $arJogo["h"];
			$nrMedia = $nrSoma / 8;
			echo "\n Media ".$nrMedia;
			
			if ( fnSnPar( $arJogo["a"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["b"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["c"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["d"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["e"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["f"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["g"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["h"] ) ){$nrPares = $nrPares + 1;}
			echo  " Pares ".$nrPares;
			
			
			if ($nrMedia > 24 and $nrMedia < 36)
			{
				$strSQL = "UPDATE tbl_SenaJogos8 SET media = '".round($nrMedia)."', pares = $nrPares WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
			}else{				
				$strSQL = "DELETE FROM tbl_SenaJogos8 WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
				echo "e";
			}
			
			
	}
}



if (	$_POST["jogoslimitar"] == "jogoslimitar" and is_numeric($_POST["qtdd"]) )
	{
	
	$strSQL = "SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos8  WHERE pares = 4  ";
	$res = $conn->query($strSQL);
	$total = mysql_result($res, 0, 0);
	echo "Total de jogos: $total <br> \n";
	$frequencia = floor($total/$_POST["qtdd"]);
	echo "frequencia: $frequencia <br> \n";
	$qtdd = $_POST["qtdd"];
	echo "qtdd: $qtdd <br> \n";
	
	$i = 0;
	$linha = 0;
	$jogo = 0;
	$strSQL = "SELECT * FROM tbl_SenaJogos8 WHERE pares = 4 ORDER BY a, b, c, d, e, f, g, h ";
	$resJogos = $conn->query($strSQL);
	while($arJogo = mysql_fetch_array($resJogos))
	{
		$i++;
		if ($i == $frequencia )
		{
			$jogo++;
			//echo $arJogo["a"]." ".$arJogo["b"]." ".$arJogo["c"]." ".$arJogo["d"]." ".$arJogo["e"]." ".$arJogo["f"]."\n";		
			echo "jogo ".fnDoisDigitos($jogo).": ". fnDoisDigitos($arJogo["a"])." ".fnDoisDigitos($arJogo["b"])." ".fnDoisDigitos($arJogo["c"])." ".fnDoisDigitos($arJogo["d"])." ".fnDoisDigitos($arJogo["e"])." ".fnDoisDigitos($arJogo["f"])." ".fnDoisDigitos($arJogo["g"])." ".fnDoisDigitos($arJogo["h"])." \n";	
			$linha++;
			if ($linha==3){echo "<br>\n";$linha = 0;}
			$i=0;
		}
	}
}
?>
</pre>
<form method="post">
Jogos: <strong><?php
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos8";
$res = $conn->query($strSQL);
echo mysql_result($res, 0, 0);
?></strong>
<br>
Jogos 4 pares + 4 ímpares: <strong><?php
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos8 WHERE pares = 4";
$res = $conn->query($strSQL);
echo mysql_result($res, 0, 0);
?></strong>
<br>
Qtdd de jogos: <input type="text" name="qtdd" value="70">
<br>

  Clique aqui para limitar: <input type="submit" name="jogoslimitar" value="jogoslimitar">
<br>
<br>
  Clique aqui para validar: <input type="submit" name="validar" value="sim">
<br>
<br>

</form>

<?php include_once("lib.footer.php") ?>
</body>
</html>
