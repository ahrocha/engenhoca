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
  <input name="a" type="text" id="a" value="">
  <input name="b" type="text" id="b" value="">
  <input type="submit" name="submit" value="Enviar">
</form>
<?php
if(strlen($a) > 0){
  ?><h2>geral</h2><?php
  $strSQL = "SELECT * FROM tbl_SenaNum WHERE cd = $a";
  $result = $conn->query($strSQL);
  $array = mysql_fetch_array($result);
  ?>
  <p><?php echo $a;?> - qtdd: <?php echo $array["qtdd"];?> - ultima: <?php echo $array["ultima"];?></p>
  <?php

  ?><h2>�ltimas vezes</h<?php<?
  $strSQL = "SELECT * FROM tbl_Sena WHERE num = $a ORDER BY jogo DESC";
  $result = $conn->query($strSQL);
  while ($array = mysql_fetch_array($result)){
  	echo "jogo: ".$array["jogo"];
	$strSQL = "SELECT * FROM tbl_Sena WHERE jogo = ".$array["jogo"];
	if(strlen($b) > 0){	$strSQL = "SELECT * FROM tbl_Sena WHERE jogo = ".$array["jogo"]." AND num = $b";}
	$resultAux = $conn->query($strSQL);
	while ($array = mysql_fetch_array($resultAux)){
		echo " ".$array["num"];
	}
	echo "<br>\n";  
  }
}
?>
<h2>trios</h2>
<?php
if (strlen($b) > 0){
	for ($i = 1; $i <= 80; $i++) {
		if ($i < $a){
			$strSQL = "SELECT * FROM tbl_SenaTrios WHERE a = $i AND b = $a AND c = $b";
			$result = $conn->query($strSQL);
			while ($array = mysql_fetch_array($result)){
				echo $array["a"]." - ".$array["b"]." - ".$array["c"]." - ".$array["nr"]." <br> \n ";
			}
		}
		if ($i > $a AND $i < $b ){
			$strSQL = "SELECT * FROM tbl_SenaTrios WHERE a = $a AND b = $i AND c = $b";
			$result = $conn->query($strSQL);
			while ($array = mysql_fetch_array($result)){
				echo $array["a"]." - ".$array["b"]." - ".$array["c"]." - ".$array["nr"]." <br> \n ";
			}
		}
		if ($i > $c){
			$strSQL = "SELECT * FROM tbl_SenaTrios WHERE a = $a AND b = $b AND c = $i";
			$result = $conn->query($strSQL);
			while ($array = mysql_fetch_array($result)){
				echo $array["a"]." - ".$array["b"]." - ".$array["c"]." - ".$array["nr"]." <br> \n ";
			}
		}
	}
}
?>
<?php include_once("lib.footer.php") ?>
</body>
</html>
