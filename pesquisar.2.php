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
<h2>Pesquisar</h2>
<form method="post">
  N&uacute;mero: 
  <input name="a" type="text" value="" size="4">
  <input name="b" type="text" value="" size="4">
  <input name="c" type="text" value="" size="4">
  <input name="d" type="text" value="" size="4">
  <input name="e" type="text" value="" size="4">
  <input name="f" type="text" value="" size="4">
  <input type="submit" name="submit" value="Enviar">
</form>
<?php
if (strlen($a) > 0){
	$strSQL = "SELECT * FROM tbl_Sena WHERE num = $a";
	$result = $conn->query($strSQL);
	while($array = mysql_fetch_array($result)){
		$strSQL = "SELECT * FROM tbl_Sena WHERE num = $b AND jogo = ".$array["jogo"];
		$resAux = $conn->query($strSQL);
		while ($arAux = mysql_fetch_array($resAux)){
			echo " <br> \n".$arAux["jogo"];
			$strSQL = " SELECT * FROM tbl_Sena WHERE jogo = ".$arAux["jogo"];
			$resAuxB = $conn->query($strSQL);
			while($arAuxB = mysql_fetch_array($resAuxB)){
				echo " - ".$arAuxB["num"]." \n ";
			}
		}
	}	
}
?>
<?php include_once("lib.footer.php") ?>
</body>
</html>
