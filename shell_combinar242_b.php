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
<h1>Combinar 2 x 4 x 2</h1>

<?php

$parte = 2;
$nrJogo = 0;

//if($_POST["frmFuncao"] == "combinar")
if( $parte == 1)
{
$strInicio = date("H:i:s");	
$strSQL = " TRUNCATE TABLE `tbl_SenaJogos8`  ";
$conn->query($strSQL);

//45 46;54 50;21 36;60 12;20 42;56 40;07 59;19 48
//52 09;10 05;14 38;16 39;13 31;51 30;08 17;01 26;11 32;37 47
//58 34;04 15;55 44;29 41;53 23;57 24;28 27;25 06;22 03;49 02;35 18;33 43
	
	$arMais   = explode(";", "45 46;54 50;21 36;60 12;20 42;56 40;07 59;19 48" );
	$arOutros = explode(";", "52;09;10;05;14;38;16;39;13;31;51;30;08;17;01;26;11;32;37;47" );
	$arMenos  = explode(";", "58 34;04 15;55 44;29 41;53 23;57 24;28 27;25 06;22 03;49 02;35 18;33 43" );
	
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
		//$arDezena2 = array_diff($arMais, array($nrDezena1));
		$arDezena2 = $arOutros;
		foreach($arDezena2 as $nrDezena2)
		{
		//
		$arDezena3 = array_diff($arDezena2, array($nrDezena2));
		foreach($arDezena3 as $nrDezena3)
		{
			
		$arDezena4 = array_diff($arDezena3, array($nrDezena3));
		foreach($arDezena4 as $nrDezena4)
		{
			
		$arDezena5 = array_diff($arDezena4, array($nrDezena4));
		foreach($arDezena5 as $nrDezena5)
		{

				$arDezena6 = $arMenos;//array_diff($arDezena3, array($nrDezena3));
				foreach($arDezena6 as $nrDezena6)
				{
					
						
							//
//							echo "$nrDezena1 $nrDezena2 $nrDezena3 $nrDezena4 <br> \n";
// INICIO JOGO DEFINIDO

	$arrayDezena1 = explode(" ", $nrDezena1);
//	$arrayDezena2[] =  $nrDezena2;
//	$arrayDezena3[] =  $nrDezena3;
//	$arrayDezena4[] =  $nrDezena4;
//	$arrayDezena5[] =  $nrDezena5;
	$arrayDezena6 = explode(" ", $nrDezena6);
	$arJogo = array($arrayDezena1[0], $arrayDezena1[1], $nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $arrayDezena6[0], $arrayDezena6[1] );
	sort($arJogo);
	//print_r($arJogo);
									
//									echo "<br> \n cadastrar $a $b $c $d $e $f | ";
//									$nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
//									$nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
//									$nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
//									$nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
//									$nrMedia     =  array_sum($jogo) / 6;

				$strSQL = "SELECT COUNT(*) AS nrTotal FROM tbl_SenaJogos8 WHERE
					a =  ".$arJogo[0]." AND 
					b =  ".$arJogo[1]." AND
					c =  ".$arJogo[2]." AND
					d =  ".$arJogo[3]." AND
					e =  ".$arJogo[4]." AND
					f =  ".$arJogo[5]." AND
					g =  ".$arJogo[6]." AND
					h =  ".$arJogo[7]."
				";
				$resAux = $conn->query($strSQL);
				echo mysql_error();
				if ( mysql_result($resAux, 0, "nrTotal") == 0)
				{
					$strSQL = "
						INSERT INTO tbl_SenaJogos8
						( a , b , c , d , e , f, g, h )
						VALUES
						( ".$arJogo[0]." ,".$arJogo[1].", ".$arJogo[2].", ".$arJogo[3].", ".$arJogo[4].", ".$arJogo[5]." , ".$arJogo[6]." , ".$arJogo[7]." )
					";
					$conn->query($strSQL);
					//echo "\n".$strSQL."\n";
				}

echo "<br>\n".$nrJogo."  ";
$nrJogo++;
if ($nrJogo > 2000000 ){
		$strFinal = date("H:i:s");
	echo "\n<br><br>\n.$strInicio até $strFinal";
	exit();
	
	}

//									unset($arDezena1, $arDezena2, $arDezena3, $arDezena4);
//									unset($nrDezena1, $nrDezena2, $nrDezena3, $nrDezena4);
									unset($arJogo);
									set_time_limit(0);
// FINAL JOGO DEFINIDO
					//echo "$nrDezena1 $nrDezena2 $nrDezena3 $nrDezena4 <br> \n";
				} // foreach($arDezena2 as $nrDezena2)
			} // foreach($arMais as $nrDezena1)
		//
		}
		}
		} // foreach($arDezena2 as $nrDezena2)
	} // foreach($arMais as $nrDezena1)
	$strFinal = date("H:i:s");
	echo "\n<br><br>\n.$strInicio até $strFinal";
} // if 1==1


if ($parte == 2 )
{
	$strSQL = "SELECT * FROM tbl_SenaJogos8 WHERE pares = 0 AND media = 0 ";	
	$resJogos = $conn->query($strSQL);
	echo "\nJogos: ".mysql_num_rows($resJogos);
	while ($arJogo = mysql_fetch_array($resJogos))
	{
			$nrPares = 0;
			//print_r($arJogo);
			$nrSoma = $arJogo["a"] + $arJogo["b"] + $arJogo["c"] + $arJogo["d"] + $arJogo["e"] + $arJogo["f"] + $arJogo["g"] + $arJogo["h"];
			$nrMedia = $nrSoma / 8;
			echo "\n ".$arJogo["cd"]." Media ".$nrMedia;
			
			if ( fnSnPar( $arJogo["a"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["b"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["c"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["d"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["e"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["f"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["g"] ) ){$nrPares = $nrPares + 1;}
			if ( fnSnPar( $arJogo["h"] ) ){$nrPares = $nrPares + 1;}
			echo  " Pares ".$nrPares;
			
			
			$strSQL = "UPDATE tbl_SenaJogos8 SET media = '".round($nrMedia)."', pares = $nrPares WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
			$conn->query($strSQL);
	}
	$strSQL = "DELETE FROM tbl_SenaJogos8 WHERE pares = 6 OR pares = 7 OR pares = 8 ";
	$conn->query($strSQL);
	echo "\n apagados maiores que 5 ".mysql_affected_rows();
	$strSQL = "DELETE FROM tbl_SenaJogos8 WHERE pares = 1 OR pares = 2 ";
	$conn->query($strSQL);
	echo "\n apagados 1 ou 2 ".mysql_affected_rows();
	$strSQL = "DELETE FROM tbl_SenaJogos8 WHERE media < 21 AND media <> 0 ";
	$conn->query($strSQL);
	echo "\n apagados media menor que 21  ".mysql_affected_rows();
	$strSQL = "DELETE FROM tbl_SenaJogos8 WHERE media > 40 AND media <> 0  ";
	$conn->query($strSQL);
	echo "\n apagados media maior que 40  ".mysql_affected_rows();
	$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos8  ";
	$result = $conn->query($strSQL);
	echo "\n restantes  ".mysql_result($result, 0, 0);
	
}
?>


<?php include_once("lib.footer.php") ?>
</body>
</html>
