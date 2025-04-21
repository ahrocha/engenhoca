<?php

include_once("header.php");

?>

<h2>Exportar jogos</h2>

<h2>Exportar</h2>
<pre>
INSERT INTO `concurso` (`loteria_id`, `numero`, `a`, `b`, `c`, `d`, `e`, `f`, `data`) VALUES
<?php
// listar últimos jogos
// INSERT INTO `concurso` (`id`, `loteria_id`, `numero`, `a`, `b`, `c`, `d`, `e`, `f`, `data`) VALUES
// (1, 1, 1, 4, 5, 30, 33, 41, 52, '1996-03-11'),
// (2, 1, 2, 9, 37, 39, 41, 43, 49, '1996-03-16');
//

// INSERT INTO `concurso` (`loteria_id`, `numero`, `a`, `b`, `c`, `d`, `e`, `f`, `data`) VALUES
// (1, 1, 4, 5, 30, 33, 41, 52, '1996-03-11'),
// (1, 2, 9, 37, 39, 41, 43, 49, '1996-03-16');

$strSQL = "SELECT * FROM (SELECT jogo FROM tbl_Sena WHERE jogo > 1000 GROUP BY jogo ORDER BY jogo) AS s ORDER BY jogo ";
$resSorteios = $conn->query($strSQL);
while($arSorteio = $resSorteios->fetch_array())
{
	$proximojogo = $arSorteio["jogo"] + 1;
	echo "(1, ";
	echo $arSorteio["jogo"].", ";
	$strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$arSorteio["jogo"]." ORDER BY num ";
	$resSorteado = $conn->query($strSQL);
	
	while($arSorteado = $resSorteado->fetch_array())
	{
		echo $arSorteado["num"].", ";
	}
	echo "'1996-03-17'),".PHP_EOL;
}

?>
</pre>
<h2>Changelog</h2>
<p>- 2009.03.28 -<br>
Nova regra que exibe os n&uacute;meros que mais sa&iacute;ram nos &uacute;ltimos 10 sorteios.<br>
  Filtro de montagem de n&uacute;meros que elimina os jogos com 3 sequ&ecirc;ncias.</p>
<?php include_once("footer.php"); ?>
</body>
</html>
