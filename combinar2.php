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
if($_POST["frmFuncao"] == "18numeros")
{
	$modelo = "

A G M Q F L
B H N R E K
C I O D J P

A B G H M N
C D I J O P
E F K L Q R

B C H I Q N
D E J K O P
F A L G M R

A D I L M R
B E H K O N
C F G J P Q

A G M E J Q 
B H N F K M
C I O A L N
D J P B G R
E K Q C H P
F L R D I O

";
	$zzz = " &nbsp; ";
	$modelo = str_replace("A", $zzz.$_POST["a"], $modelo);
	$modelo = str_replace("B", $zzz.$_POST["b"], $modelo);
	$modelo = str_replace("C", $zzz.$_POST["c"], $modelo);
	$modelo = str_replace("D", $zzz.$_POST["d"], $modelo);
	$modelo = str_replace("E", $zzz.$_POST["e"], $modelo);
	$modelo = str_replace("F", $zzz.$_POST["f"], $modelo);
	$modelo = str_replace("G", $zzz.$_POST["g"], $modelo);
	$modelo = str_replace("H", $zzz.$_POST["h"], $modelo);
	$modelo = str_replace("I", $zzz.$_POST["i"], $modelo);
	$modelo = str_replace("J", $zzz.$_POST["j"], $modelo);
	$modelo = str_replace("K", $zzz.$_POST["k"], $modelo);
	$modelo = str_replace("L", $zzz.$_POST["l"], $modelo);
	$modelo = str_replace("M", $zzz.$_POST["m"], $modelo);
	$modelo = str_replace("N", $zzz.$_POST["n"], $modelo);
	$modelo = str_replace("O", $zzz.$_POST["o"], $modelo);
	$modelo = str_replace("P", $zzz.$_POST["p"], $modelo);
	$modelo = str_replace("Q", $zzz.$_POST["q"], $modelo);
	$modelo = str_replace("R", $zzz.$_POST["r"], $modelo);
	
	?>
<pre><?php echo $modelo; ?></pre>
	<?php
}
?>
<form method="post">
  <p>18 n&uacute;meros</p>
  <table width="500" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right" nowrap>A 
      <input name="a" type="text" id="a" size="6"></td>
      <td align="right" nowrap>B
      <input name="b" type="text" id="b" size="6"></td>
      <td align="right" nowrap>C
      <input name="c" type="text" id="c" size="6"></td>
      <td align="right" nowrap>D
      <input name="d" type="text" id="d" size="6"></td>
      <td align="right" nowrap>E
      <input name="e" type="text" id="e" size="6"></td>
      <td align="right" nowrap>F
      <input name="f" type="text" id="f" size="6"></td>
    </tr>
    <tr>
      <td align="right" nowrap>G
      <input name="g" type="text" id="g" size="6"></td>
      <td align="right" nowrap>H
      <input name="h" type="text" id="h" size="6"></td>
      <td align="right" nowrap>I
      <input name="i" type="text" id="i" size="6"></td>
      <td align="right" nowrap>j
        <input name="j" type="text" id="j" size="6"></td>
      <td align="right" nowrap>k
        <input name="k" type="text" id="k" size="6"></td>
      <td align="right" nowrap>l
        <input name="l" type="text" id="l" size="6"></td>
    </tr>
    <tr>
      <td align="right" nowrap>m
        <input name="m" type="text" id="m" size="6"></td>
      <td align="right" nowrap>n
        <input name="n" type="text" id="n" size="6"></td>
      <td align="right" nowrap>o
        <input name="o" type="text" id="o" size="6"></td>
      <td align="right" nowrap>p
        <input name="p" type="text" id="p" size="6"></td>
      <td align="right" nowrap>&nbsp;</td>
      <td align="right" nowrap>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" nowrap>q
        <input name="q" type="text" id="q" size="6"></td>
      <td align="right" nowrap>r
        <input name="r" type="text" id="r" size="6"></td>
      <td align="right" nowrap>&nbsp;</td>
      <td align="right" nowrap>&nbsp;</td>
      <td align="right" nowrap>&nbsp;</td>
      <td align="right" nowrap>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input name="frmFuncao" type="submit" id="frmFuncao" value="18numeros">
  </p>
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
