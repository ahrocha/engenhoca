<?php
require "../lib/lib.inc.main.php";
$nrRepetido = 0;

//set_time_limit(5);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>teste</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php include_once("lib.header.php") ?>
<h2>combinar </h2>

<?php

if($_POST["frmFuncao"] == "18numeros")
{
	$numeros = array(
		$_POST["a"],
		$_POST["b"],
		$_POST["c"],
		$_POST["d"],
		$_POST["e"],
		$_POST["f"],
		$_POST["g"],
		$_POST["h"],
		$_POST["i"],
		$_POST["j"],
		$_POST["k"],
		$_POST["l"],
		$_POST["m"],
		$_POST["n"],
		$_POST["o"],
		$_POST["p"],
		$_POST["q"],
		$_POST["r"],
		$_POST["s"],
		$_POST["t"],
		$_POST["u"],
		$_POST["v"],
		$_POST["w"],
		$_POST["x"]);

		$arMais = array($_POST["a"], $_POST["b"], $_POST["c"], $_POST["d"], $_POST["e"], $_POST["f"]);
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
  <p>24 n&uacute;meros</p>
  <table width="500" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right" nowrap>A 
      <input name="a" type="text" id="a" size="6" value="<?php echo $_POST["a"];?>" ></td>
      <td align="right" nowrap>B
      <input name="b" type="text" id="b" size="6" value="<?php echo $_POST["b"];?>" ></td>
      <td align="right" nowrap>C
      <input name="c" type="text" id="c" size="6" value="<?php echo $_POST["c"];?>" ></td>
      <td align="right" nowrap>D
      <input name="d" type="text" id="d" size="6" value="<?php echo $_POST["d"];?>" ></td>
      <td align="right" nowrap>E
      <input name="e" type="text" id="e" size="6" value="<?php echo $_POST["e"];?>" ></td>
      <td align="right" nowrap>F
      <input name="f" type="text" id="f" size="6" value="<?php echo $_POST["f"];?>" ></td>
    </tr>
    <tr>
      <td align="right" nowrap>G
      <input name="g" type="text" id="g" size="6" value="<?php echo $_POST["g"];?>" ></td>
      <td align="right" nowrap>H
      <input name="h" type="text" id="h" size="6" value="<?php echo $_POST["h"];?>" ></td>
      <td align="right" nowrap>I
      <input name="i" type="text" id="i" size="6" value="<?php echo $_POST["i"];?>" ></td>
      <td align="right" nowrap>j
        <input name="j" type="text" id="j" size="6" value="<?php echo $_POST["j"];?>" ></td>
      <td align="right" nowrap>k
        <input name="k" type="text" id="k" size="6" value="<?php echo $_POST["k"];?>" ></td>
      <td align="right" nowrap>l
        <input name="l" type="text" id="l" size="6" value="<?php echo $_POST["l"];?>" ></td>
    </tr>
    <tr>
      <td align="right" nowrap>m
        <input name="m" type="text" id="m" size="6" value="<?php echo $_POST["m"];?>" ></td>
      <td align="right" nowrap>n
        <input name="n" type="text" id="n" size="6" value="<?php echo $_POST["n"];?>" ></td>
      <td align="right" nowrap>o
        <input name="o" type="text" id="o" size="6" value="<?php echo $_POST["o"];?>" ></td>
      <td align="right" nowrap>p
        <input name="p" type="text" id="p" size="6" value="<?php echo $_POST["p"];?>" ></td>
      <td align="right" nowrap>q
      <input name="q" type="text" id="q" size="6" value="<?php echo $_POST["q"];?>" ></td>
      <td align="right" nowrap>r
      <input name="r" type="text" id="r2" size="6" value="<?php echo $_POST["r"];?>" ></td>
    </tr>
    <tr>
      <td align="right" nowrap>S
      <input name="s" type="text" id="s" size="6" value="<?php echo $_POST["s"];?>" ></td>
      <td align="right" nowrap>T
      <input name="t" type="text" id="r4" size="6" value="<?php echo $_POST["t"];?>" ></td>
      <td align="right" nowrap>U
      <input name="u" type="text" id="r5" size="6" value="<?php echo $_POST["u"];?>" ></td>
      <td align="right" nowrap>V
      <input name="v" type="text" id="r6" size="6" value="<?php echo $_POST["v"];?>" ></td>
      <td align="right" nowrap>W
      <input name="w" type="text" id="r7" size="6" value="<?php echo $_POST["w"];?>" ></td>
      <td align="right" nowrap>X
      <input name="x" type="text" id="r8" size="6" value="<?php echo $_POST["x"];?>" ></td>
    </tr>
  </table>
  <p>
    <input name="frmFuncao" type="submit" id="frmFuncao" value="18numeros">
  </p>
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
