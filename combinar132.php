<?php
require "lib.main.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- $Id: htmlquickstart.kmdr,v 1.12 2003/10/04 22:04:17 amantia Exp $ -->
<head><?php
include "lib.html.head.php";
?>
</head>
<body>
<?php include_once("lib.header.php") ?>
<h1>Combinar 1 x 3 x 2</h1>

<?php

if($_POST["frmFuncao"] == "combinar")
{
	$arMais   = explode(";",   $_POST["mais"]);
	$arOutros = explode(";", $_POST["outros"]);
	$arMenos  = explode(";",  $_POST["menos"]);
	
	sort($arMais);
	sort($arOutros);
	sort($arMenos);
	
	// primeiro validar
	print_r($arMais);
	print_r($arOutros);
	print_r($arMenos);
	// depois combinar
	
	foreach($arMais as $nrDezena1)
	{
		$arDezena2 = $arOutros; //array_diff($arMais, array($nrDezena1));
		foreach($arDezena2 as $nrDezena2)
		{
		//
			$arDezena3 = array_diff($arDezena2, array($nrDezena2));
			foreach($arDezena3 as $nrDezena3)
			{
				$arDezena4 = array_diff($arDezena3, array($nrDezena3));
				foreach($arDezena4 as $nrDezena4)
				{
					$arDezena5 = $arMenos; //array_diff($arDezena4, array($nrDezena4));
					foreach($arDezena5 as $nrDezena5)
					{
						$arDezena6 = array_diff($arDezena5, array($nrDezena5));
						foreach($arDezena6 as $nrDezena6)
						{
							//
//							echo "$nrDezena1 $nrDezena2 $nrDezena3 $nrDezena4 $nrDezena5 $nrDezena6 <br> \n";
// INICIO JOGO DEFINIDO
									$jogo = array($nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
									sort($jogo);
									$a = $jogo[0];
									$b = $jogo[1];
									$c = $jogo[2];
									$d = $jogo[3];
									$e = $jogo[4];
									$f = $jogo[5];
//									echo "<br> \n cadastrar $a $b $c $d $e $f | ";
									$nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
									$nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
									$nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
									$nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
									$nrMedia     =  array_sum($jogo) / 6;
									if (
											( $nrColunas == 6 and $nrLinhas > 3 and $nrLinha1 < 3 and $nrSequencia <= 1 and $nrMedia > 20 and $nrMedia < 40 ) OR 
											( $nrColunas >= 5 and $nrLinhas > 3 and $nrLinha1 < 3 and $nrSequencia == 0 and $nrMedia > 20 and $nrMedia < 40 )
										){
										$strSQL = "SELECT cd FROM tbl_SenaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
										$resultRepetido = $conn->query($strSQL);
										if (mysql_num_rows($resultRepetido) == 0)
										{
											$strSQL = "
												INSERT INTO tbl_SenaJogos
												( a , b , c , d , e , f)
												VALUES
												($a ,$b, $c, $d, $e, $f)
											";
											$conn->query($strSQL);
										} else {// repetido = 0
											$nrRepetido++;
										} // if (mysql_num_rows($resultRepetido) == 0){
									} // if ($nrColunas == 6){
									set_time_limit(0);
// FINAL JOGO DEFINIDO
						} // foreach($arDezena2 as $nrDezena2)
					} // foreach($arMais as $nrDezena1)
					//echo "$nrDezena1 $nrDezena2 $nrDezena3 $nrDezena4 <br> \n";
				} // foreach($arDezena2 as $nrDezena2)
			} // foreach($arMais as $nrDezena1)
		//
		} // foreach($arDezena2 as $nrDezena2)
	} // foreach($arMais as $nrDezena1)
	
} // if post
if($_POST["frmFuncao"] == "18numeros")
{
	$numeros = array(
		$_POST["a"], $_POST["b"], $_POST["c"], $_POST["d"], $_POST["e"], $_POST["f"],
		$_POST["g"], $_POST["h"], $_POST["i"], $_POST["j"], $_POST["k"], $_POST["l"],

		$_POST["m"], $_POST["n"], $_POST["o"], $_POST["p"], $_POST["q"], $_POST["r"],
		$_POST["s"],
		$_POST["t"],
		$_POST["u"],
		$_POST["v"],
		$_POST["w"],
		$_POST["x"]);

		$arMais      = array($_POST["a1"], $_POST["a2"], $_POST["a3"], $_POST["a4"], $_POST["a5"], $_POST["f"]);
		$arMaisMenos = array($_POST["g"], $_POST["h"], $_POST["i"], $_POST["j"], $_POST["k"], $_POST["l"]);
//		$arAtrasados = array($_POST["m"], $_POST["n"], $_POST["o"], $_POST["p"]);
//		$arMenos = array($_POST["q"], $_POST["r"], $_POST["s"], $_POST["t"]);
		$arMenos = array($_POST["m"], $_POST["n"], $_POST["o"], $_POST["p"], $_POST["q"], $_POST["r"]);
		$arSequencia = array($_POST["s"], $_POST["t"], $_POST["u"], $_POST["v"], $_POST["w"], $_POST["x"]);

		foreach($arMais as $dezena1)
		{
			echo "<br>";
			$numerosnivel1 = array_diff($arMais, array($dezena1));
			//print_r($numnivel1);
			foreach($numerosnivel1 as $dezena2)
			{
				if (1 == 1)
				{ 
//					mail("andrey@hurpia.com.br", "[sena] inicio $dezena1 e $dezena2 ", "[sena] inicio $dezena1 e $dezena2 ");
					echo "Dezenas: $dezena1 e $dezena2 <br> ";
					echo "horario: ".date('h:i:s')." <br> <br>";
					$numerosnivel2 = $arMaisMenos;	
					foreach($numerosnivel2 as $dezena3)
					{
						$numerosnivel3 = array_diff($numerosnivel2, array($dezena3));	
						foreach($numerosnivel3 as $dezena4)
						{
							$numerosnivel4 = $arMenos;
							foreach($numerosnivel4 as $dezena5)
							{
								$numerosnivel5 = $arSequencia;
								foreach($numerosnivel5 as $dezena6)
								{
									$numerosnivel6 = array_diff($numerosnivel5, array($dezena6));
									$jogo = array($dezena1 ,$dezena2, $dezena3, $dezena4, $dezena5, $dezena6);
									sort($jogo);
									$a = $jogo[0];
									$b = $jogo[1];
									$c = $jogo[2];
									$d = $jogo[3];
									$e = $jogo[4];
									$f = $jogo[5];
									
									$nrColunas   =    fnConfereColunas($a, $b, $c, $d, $e, $f);
									$nrLinhas    =     fnConfereLinhas($a, $b, $c, $d, $e, $f);
									$nrLinha1    = fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
									$nrSequencia =  fnConfereSequencia($a, $b, $c, $d, $e, $f);
									if ($nrColunas == 6 and $nrLinhas > 3 and $nrLinha1 < 3 and $nrSequencia == 0){
										$strSQL = "SELECT cd FROM tbl_QuinaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
										$resultRepetido = $conn->query($strSQL);
										if (mysql_num_rows($resultRepetido) == 0)
										{
											$strSQL = "
												INSERT INTO tbl_QuinaJogos
												( a , b , c , d , e , f)
												VALUES
												($a ,$b, $c, $d, $e, $f)
											";
											$conn->query($strSQL);
										} else {// repetido = 0
											$nrRepetido++;
										} // if (mysql_num_rows($resultRepetido) == 0){
									} // if ($nrColunas == 6){
									set_time_limit(0);
								}
							}
						}	
					}
				} // if ($final1 <> $final2)
			} // foreach($numerosnivel1 as $dezena2)
		} // foreach($numeros as $dezena1)
		
		echo "<br>Repetidos: $nrRepetido<br><br>";
} // if post
?>

<form method="post">
  <p>30 n&uacute;meros - formato: a;b;c;d;e;f;g;h;i;j;k;l;m;n;o;p;q</p>
  <p>grupo a - 3 por jogo: 
    <input name="mais" type="text" id="mais" size="40" value="<?php echo $_POST["mais"];?>" >
  </p>
  <p>grupo b - 2 por jogo: 
    <input name="outros" type="text" id="outros" size="40" value="<?php echo $_POST["outros"];?>" >
  </p>
  <p>grupo c - 1 por jogo: 
    <input name="menos" type="text" id="menos" size="40" value="<?php echo $_POST["menos"];?>" >
  </p>
  <p>
    <input name="frmFuncao" type="submit" id="frmFuncao" value="combinar">
  </p>
</form>


<?php include_once("lib.footer.php") ?>
</body>
</html>
