<form method="post">
  Clique aqui para gerar nova estatística: <input type="submit" name="gerar" value="gerar">
</form>

<?php

echo "Ultimo sorteio: ".$ultimoSorteio." <br> \n";
$dezultimos = $ultimoSorteio - 10;

?>
<hr>
<p>
<?php
if (isset($resumo)) {
	echo "Mais:  ".$resumo["mais"]."<br>\n";
	echo "Meio:  ".$resumo["meio"]."<br>\n";
	echo "Menos: ".$resumo["menos"]."<br>\n";
	echo "Entre os dez ultimos: ".$resumo["dez"]."<br>\n";
	echo "Dezenas siferentes nos dez ultimos: ".$resumo["totaldez"]."<br>\n";
}

?>
<hr>
<p>Mais</p>
<?php
if (isset($mais)) {
	foreach($mais as $array)
	{
		echo $array["nr"]." - ".$array["nrMaisSorteio"]."<br>\n";
	}
}
?>
<p>Meio</p>
<?php
if (isset($meio)) {
	foreach($meio as $array)
	{
		echo $array["nr"]." - ".$array["nrMeioSorteio"]."<br>\n";
	}
}
?>
<p>Menos</p>
<?php
if (isset($menos)) {
	foreach($menos as $array)
	{
		echo $array["nr"]." - ".$array["nrMenosSorteio"]."<br>\n";
	}
}

?>
<hr>
<h2>Última vez que repetiram</h2>
<?php
if (isset($ultimaRepeticao)) {
	foreach($ultimaRepeticao as $key => $array)
	{
		echo $key." - ".$array["num"]." - ".$array["repeticao"]."<br>\n";
	}
}
