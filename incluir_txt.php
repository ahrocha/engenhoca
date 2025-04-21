<?php
require "../lib/lib.inc.main.php";
$nrRepetido = 0;

function fnDataInverte($data)
{
	$d = explode("/", $data);
	return $d[2]."-".$d[1]."-".$d[0];
}

/**
 * @link http://gist.github.com/385876
 */
function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 10000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                //$data[] = array_combine($header, $row);
				$data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- $Id: htmlquickstart.kmdr,v 1.12 2003/10/04 22:04:17 amantia Exp $ -->
<head>
  <title>incluir de arquivo txt</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet">
</head>
<body>
<?php include_once("lib.header.php") ?>
<h2>atualizar de arquivo texto </h2>

<?php

if($_POST["f"] == "incluirTxt")
{
	echo "<p>Vai atualizar</p>";
	$arquivo = $_POST["arquivo"];
	$lines = file($arquivo);
	$total = count($lines);
	echo "<p>Linhas: $total</p>";
	
$array = csv_to_array($arquivo, ';', '"');

	$total = count($array);
	echo "<p>Linhas: $total</p>";
$i = 0;
foreach ($array as $arLinha)
{
	$strSQL = "SELECT * FROM tbl_SenaSorteios WHERE cdSorteio = ".$arLinha["Concurso"]." LIMIT 1 ";
	$result = $conn->query($strSQL);
	if (mysql_num_rows($result) == 0)
	{
		$data = fnDataInverte($arLinha["Data Sorteio"]);
		$strSQL = "
			INSERT INTO tbl_SenaSorteios
				(cdSorteio, numero1, numero2, numero3, numero4, numero5, numero6, dtSorteio)
				VALUES
				(".$arLinha["Concurso"].", ".$arLinha["1� Dezena"].", ".$arLinha["2� Dezena"].", ".$arLinha["3� Dezena"].", ".$arLinha["4� Dezena"].", ".$arLinha["5� Dezena"].", ".$arLinha["6� Dezena"].", '".$data."')
			";
			echo $strSQL."<br>\n";
			$conn->query ($strSQL);
	}else
	{
		echo "<p><strong>".$arLinha["Concurso"]."</strong> j� cadastrado.</p>\n";	
	}
	$i++;
}

//	foreach ($lines as $line_num => $line)
//	{
		
//	}
} // if post
?>
<form method="post">
  <p><input type="text" name="arquivo" value="0001a1568.txt"></p>
  <p><input type="submit">
    <input name="f" type="hidden" id="f" value="incluirTxt">
  </p>
</form>
<?php include_once("lib.footer.php") ?>
</body>
</html>
