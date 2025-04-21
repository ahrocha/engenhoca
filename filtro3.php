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
if (	$_POST["filtro3"] == "filtro3" )
	{

	$strSQL = "SELECT * FROM tbl_SenaJogos ";
	$resJogos = $conn->query($strSQL);
	while($arJogo = mysql_fetch_array($resJogos))
	{
	
		set_time_limit(0);
	
		$jogo = array($arJogo["a"], $arJogo["b"], $arJogo["c"], $arJogo["d"], $arJogo["e"], $arJogo["f"] );
		
		$strSQL = "SELECT * FROM tbl_SenaTrios WHERE nr > 1";
		$resTrios = $conn->query($strSQL);
		while($arTrio = mysql_fetch_array($resTrios))
		{
			$excluir = array($arTrio["a"],$arTrio["b"],$arTrio["c"]);
			$newarray = array_diff($jogo, $excluir);
			if (count($newarray) == 3)
			{
				$nrExcluidos++;
				$strSQL = "DELETE FROM tbl_SenaJogos WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
				echo " ". count($newarray)." - ";
			}else{
				echo "+ ";
			}
		} // arTrio
		echo "\n<br><br> exclu�dos: ".$nrExcluidos. " | ";
	}
	echo "\n<br><br> exclu�dos final: ".$nrExcluidos;
}
?>
<form method="post">
  Clique aqui para passar o filtro1: <input type="submit" name="filtro3" value="filtro3">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
