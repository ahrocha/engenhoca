<?php
require "../lib/lib.inc.main.php";


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
if ($_POST["filtro1"] == "filtro1"){
  $strSQL = "SELECT * FROM tbl_SenaJogos LIMIT 10000";
  $resJogos = $conn->query($strSQL);
  while($arJogo = mysql_fetch_array($resJogos))
  {
  	set_time_limit(0);
//  	echo $arJogo["a"]." - ".$arJogo["b"]." - ".$arJogo["c"]." - ".$arJogo["d"]." - ".$arJogo["e"]." - ".$arJogo["f"]." : ";

	$nrFinais = fnConfereColunas($arJogo["a"], $arJogo["b"], $arJogo["c"], $arJogo["d"], $arJogo["e"], $arJogo["f"]);
//	echo " - Colunas ".$nrFinais;
	$strSQL = "UPDATE tbl_SenaJogos SET fim = $nrFinais WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
	$conn->query($strSQL);
	
	$nrLinhas = fnConfereLinhas($arJogo["a"], $arJogo["b"], $arJogo["c"], $arJogo["d"], $arJogo["e"], $arJogo["f"]);
//	echo " - Linhas ".$nrLinhas;
//	echo "<br>";
	$strSQL = "UPDATE tbl_SenaJogos SET col = $nrLinhas WHERE cd = ".$arJogo["cd"]." LIMIT 1 ";
	$conn->query($strSQL);
	
	$nrMesmaLinha = fnConfereMesmaLinha($arJogo["a"], $arJogo["b"], $arJogo["c"], $arJogo["d"], $arJogo["e"], $arJogo["f"]);
	echo ":".$nrMesmaLinha;	
  }
  
  // apagar os errados
  $strSQL = "DELETE FROM tbl_SenaJogos WHERE fim < 6 AND fim > 0";
  $conn->query($strSQL);
  echo "<br>Eliminados mesmo fim: ".mysql_affected_rows();
  $strSQL = "DELETE FROM tbl_SenaJogos WHERE col < 4 AND fim > 0";
  $conn->query($strSQL);
  echo "<br>Eliminados mesmas dezenas: ".mysql_affected_rows();
  
}

?>
<form method="post">
  Clique aqui para passar o filtro1: <input type="submit" name="filtro1" value="filtro1">
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
