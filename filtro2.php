<?php
require "../lib/lib.inc.main.php";
$nrExcluidos = 0;

?>
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


<?php
if (	$_POST["filtro2"] == "filtro2" and 
		is_numeric($_POST["a"])  and 
		is_numeric($_POST["b"])  and 
		is_numeric($_POST["c"])  and 
		is_numeric($_POST["d"])  and 
		is_numeric($_POST["e"])  and 
		is_numeric($_POST["f"])  )
	{
	$a = $_POST["a"];
	$b = $_POST["b"];
	$c = $_POST["c"];
	$d = $_POST["d"];
	$e = $_POST["e"];
	$f = $_POST["f"];

	$excluir = array($a,$b,$c,$d,$e,$f);

	$strSQL = "SELECT * FROM tbl_SenaJogos ";
	$resJogos = $conn->query($strSQL);
	while($arJogo = mysql_fetch_array($resJogos))
	{
		$jogo = array($arJogo["a"], $arJogo["b"], $arJogo["c"], $arJogo["d"], $arJogo["e"], $arJogo["f"] );
		$newarray = array_diff($jogo, $excluir);
		if (count($newarray) < 6)
		{
			$nrExcluidos++;
			$strSQL = "DELETE FROM tbl_SenaJogos WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
			$conn->query($strSQL);
			echo count($newarray);
			echo " - ";
		}
	}
	echo "\n<br><br><br> exclu�dos: ".$nrExcluidos;
}
?>
<form method="post">
	Preencha aqui 6 n�meros - os q menos saem e os que faz tempo q n�o saem:
    A 
      <input name="a" type="text" id="a" size="6" value="<?php echo $_POST["a"];?>" >
      B
      <input name="b" type="text" id="b" size="6" value="<?php echo $_POST["b"];?>" > - 
      C
      <input name="c" type="text" id="c" size="6" value="<?php echo $_POST["c"];?>" > - 
      D
      <input name="d" type="text" id="d" size="6" value="<?php echo $_POST["d"];?>" > - 
      E
      <input name="e" type="text" id="e" size="6" value="<?php echo $_POST["e"];?>" > - 
      F
      <input name="f" type="text" id="f" size="6" value="<?php echo $_POST["f"];?>" >
      <br>
  Clique aqui para passar o filtro1: <input type="submit" name="filtro2" value="filtro2">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
