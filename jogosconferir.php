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

<?php
if (	$_POST["jogosconferir"] == "jogosconferir"  )
{
	$nrPremiavel = 0;
	$nrQuina = 0;
	$nrQuadra = 0;
	$nrTerno = 0;
	$nrSenna = 0;
	$jogos = $_POST["jogos"];
	$arJogos = explode("\n", $jogos);
	
	$sorteados = $_POST["sorteados"];
	$arSorteados = explode(" ", $sorteados);
	print_r($arSorteados);
	foreach($arJogos as $jogo)
	{
		$i = 0;
		$saida = $jogo;
		foreach($arSorteados as $sorteado)
		{
			$saida = str_replace($sorteado, "[$sorteado]", $saida, $count);
			$i = $i + $count;
		}
		if ($i >= 3)
		{
			echo $saida." - ".$i." <br> \n";
			$nrPremiavel++;
			if ($i == 6){$nrSena++;}
			if ($i == 5){$nrQuina++;}
			if ($i == 4){$nrQuadra++;}
			if ($i == 3){$nrTerno++;}
		}
		
	}
	echo " <br> <br> Premi�veis: ".$nrPremiavel ;
	echo " <br>Terno: ".$nrTerno ;
	echo " <br>Quadra: ".$nrQuadra ;
	echo " <br>Quina: ".$nrQuina ;
	echo " <br>Sena: ".$nrSena ;
}
?>

<form method="post">
Jogos: <strong><?php
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos";
$res = $conn->query($strSQL);
echo mysql_result($res, 0, 0);
?></strong>
<br>
Sorteados (separados por espa�os - coloque n&uacute;meros de dois d&iacute;gitos, ex: 08 05 06): 
<input type="text" name="sorteados" value="<?php echo $_POST["sorteados"]; ?>">
<br>

  Jogos:<br>
<textarea name="jogos"><?php echo $_POST["jogos"]; ?></textarea>  
  <br>

<input type="submit" name="jogosconferir" value="jogosconferir">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
