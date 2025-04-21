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
<h2>megasena - combinar </h2>

<?php
if($_POST["frmFuncao"] == "9pares")
{
	$a = $_POST["a"];
	$b = $_POST["b"];
	$c = $_POST["c"];
	$d = $_POST["d"];
	$e = $_POST["e"];
	$f = $_POST["f"];
	$g = $_POST["g"];
	$h = $_POST["h"];
	$j = $_POST["i"];
	
	echo "
$a &nbsp; $b &nbsp; $c <br>
$d &nbsp; $e &nbsp; $f <br>
$g &nbsp; $h &nbsp; $i <br>
$a &nbsp; $d &nbsp; $g <br>
$b &nbsp; $e &nbsp; $h <br>
$d &nbsp; $f &nbsp; $i <br>
$a &nbsp; $e &nbsp; $i <br>
$b &nbsp; $f &nbsp; $g <br>
	
	";
	?>
	<?php
}
?>
<form method="post">
  <p>9 pares</p>
  <table width="300" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right">A 
      <input name="a" type="text" id="a" size="6"></td>
      <td align="right">B
      <input name="b" type="text" id="b" size="6"></td>
      <td align="right">C
      <input name="c" type="text" id="c" size="6"></td>
    </tr>
    <tr>
      <td align="right">D
      <input name="d" type="text" id="d" size="6"></td>
      <td align="right">E
      <input name="e" type="text" id="e" size="6"></td>
      <td align="right">F
      <input name="f" type="text" id="f" size="6"></td>
    </tr>
    <tr>
      <td align="right">G
      <input name="g" type="text" id="g" size="6"></td>
      <td align="right">H
      <input name="h" type="text" id="h" size="6"></td>
      <td align="right">I
      <input name="i" type="text" id="i" size="6"></td>
    </tr>
  </table>
  <p>
    <input name="frmFuncao" type="submit" id="frmFuncao" value="9pares">
    </p>
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
