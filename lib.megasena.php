<?php
require "../lib/lib.inc.main.php";

function fnInsereTrio($a,$b,$c){
	$strSQL = "SELECT * FROM tbl_SenaTrios WHERE a = $a AND b = $b AND c = $c";
	$resultIT = $conn->query($strSQL);
	echo mysql_error();
	if (mysql_num_rows($resultIT) > 0){
		$strSQL = "UPDATE tbl_SenaTrios SET nr = nr + 1 WHERE cd = ".mysql_result($resultIT,0,0);
	}else{
		$strSQL = "INSERT into tbl_SenaTrios (a,b,c,nr) VALUES ($a,$b,$c,1)";
	}
	$resultITT = $conn->query($strSQL);
}

function fnInsereDupla($a,$b){
	$strSQL = "SELECT * FROM tbl_SenaDuplas WHERE a = $a AND b = $b";
	$resultIT = $conn->query($strSQL);
	echo mysql_error();
	if (mysql_num_rows($resultIT) > 0){
		$strSQL = "UPDATE tbl_SenaDuplas SET nr = nr + 1 WHERE cd = ".mysql_result($resultIT,0,0);
	}else{
		$strSQL = "INSERT into tbl_SenaDuplas (a,b,nr) VALUES ($a,$b,1)";
	}
	$resultITT = $conn->query($strSQL);
}

function fnVariosJogos($jogoso){
if (strlen($jogoso) > 0){
	$num = explode(";",$jogoso);
	
	$n = array($num[2],$num[3],$num[4],$num[5],$num[6],$num[7]);
	sort($n);

	$jogo = $num[0];
	$a = $n[0];
	$b = $n[1];
	$c = $n[2];
	$d = $n[3];
	$e = $n[4];
	$f = $n[5];

	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$a.")";
	$result = $conn->query($strSQL);
	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$b.")";
	$result = $conn->query($strSQL);
	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$c.")";
	$result = $conn->query($strSQL);
	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$d.")";
	$result = $conn->query($strSQL);
	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$e.")";
	$result = $conn->query($strSQL);
	$strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$jogo.",".$f.")";
	$result = $conn->query($strSQL);


	echo "<br> a- ".$a;
	echo " b- ".$b;
	echo " c- ".$c;
	echo " d- ".$d;
	echo " e- ".$e;
	echo " f- ".$f;
	echo "<br>";
	fnInsereTrio($a,$b,$c);
	fnInsereTrio($a,$b,$d);
	fnInsereTrio($a,$b,$e);
	fnInsereTrio($a,$b,$f);
	fnInsereTrio($a,$c,$d);
	fnInsereTrio($a,$c,$e);
	fnInsereTrio($a,$c,$f);
	fnInsereTrio($a,$d,$e);
	fnInsereTrio($a,$d,$f);
	fnInsereTrio($b,$c,$d);
	fnInsereTrio($b,$c,$e);
	fnInsereTrio($b,$c,$f);
	fnInsereTrio($b,$d,$e);
	fnInsereTrio($b,$d,$f);
	fnInsereTrio($c,$d,$e);
	fnInsereTrio($c,$d,$f);
	fnInsereTrio($d,$e,$f);
	
	fnInsereDupla($a,$b);
	fnInsereDupla($a,$c);
	fnInsereDupla($a,$d);
	fnInsereDupla($a,$e);
	fnInsereDupla($a,$f);
	fnInsereDupla($b,$c);
	fnInsereDupla($b,$d);
	fnInsereDupla($b,$e);
	fnInsereDupla($b,$f);
	fnInsereDupla($c,$d);
	fnInsereDupla($c,$e);
	fnInsereDupla($c,$f);
	fnInsereDupla($d,$e);
	fnInsereDupla($d,$f);
	fnInsereDupla($e,$f);
	
}
}#final da funcao



if($_POST["zerar"] == "zerar")
{
	$strSQL = "TRUNCATE `tbl_Sena`";
	if($conn->query($strSQL))
	{
		echo "<p>Tabela tbl_Sena zerada</p>";
	}	
	$strSQL = "TRUNCATE `tbl_SenaDuplas`";
	if($conn->query($strSQL))
	{
		echo "<p>Tabela tbl_SenaDuplas zerada</p>";
	}	
	$strSQL = "TRUNCATE `tbl_SenaNum`";
	if($conn->query($strSQL))
	{
		echo "<p>Tabela tbl_SenaNum zerada</p>";
	}	
	$strSQL = "TRUNCATE `tbl_SenaTrios`";
	if($conn->query($strSQL))
	{
		echo "<p>Tabela tbl_SenaTrios zerada</p>";
	}	
}


if($_POST["submit"] == "submit")
{

	$arquivo = "900.txt";
	$jogos = file($arquivo);
	$total = count($lines);
	
	   foreach ($jogos as $jogos) {
		 fnVariosJogos($jogos);
	   }
}

?>