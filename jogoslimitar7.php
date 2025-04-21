<?php 
require_once "lib.main.php";
require_once "header.php";
$nrExcluidos = 0;

$numerosPrimos = array ( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

?>


<pre>
<?php 


if ( $_POST["jogoslimitar"] == "jogoslimitar" and is_numeric($_POST["qtdd"]) )
	{
	
	$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos7 ";
	$res = $conn->query($strSQL);
	$total = mysql_result($res, 0, 0);
	
	$frequencia = floor($total/$_POST["qtdd"]);
	$i = 0;
	$linha = 0;
	$strSQL = "SELECT * FROM tbl_SenaJogos7 ORDER BY a, b, c, d, e, f, g ";
	$resJogos = $conn->query($strSQL);
	while($arJogo = $resJogos->fetch_assoc())
	{
		$i++;
		if ($i == $frequencia)
		{
			//echo $arJogo["a"]." ".$arJogo["b"]." ".$arJogo["c"]." ".$arJogo["d"]." ".$arJogo["e"]." ".$arJogo["f"]."\n";		
			echo fnDoisDigitos($arJogo["a"])." ".fnDoisDigitos($arJogo["b"])." ".fnDoisDigitos($arJogo["c"])." ".fnDoisDigitos($arJogo["d"])." ".fnDoisDigitos($arJogo["e"])." ".fnDoisDigitos($arJogo["f"])." ".fnDoisDigitos($arJogo["g"])." \n";	
			$i = 0;
			$linha++;
			if ($linha==2){echo "\n";$linha = 0;}
		}
	}
}
?>
</pre>
<form method="post">

<br>
Qtdd de jogos: <input type="text" name="qtdd" value="70">
<br>

  Clique aqui para passar o filtro1: <input type="submit" name="jogoslimitar" value="jogoslimitar">
</form>
<br><br>
<?php 

function countSequencias( array $num ){
	
	sort($num);
	$count = count($num);
	$actual = null;
	$return = 0;
	for ($i=0; $i < $count; $i++) { 
		if(!is_null( $actual ) && ($num[$i] - $actual) == 1 ){
			$return++;
		}
		$actual = $num[$i];
	}

	return $return;

}

switch(@$_POST["f"]){

	case "mesmo_comeco":
		$deleted = 0;
		?><h3>Eliminando 3 números com mesmo começo </h3><?php 
		$strSQL = " SELECT * FROM tbl_SenaJogos7 ";
		$res = $conn->query($strSQL);

		while($ar = $res->fetch_assoc())
		{
			$arr['a'] = substr( fnDoisDigitos($ar['a']) , 0, 1 );
			$arr['b'] = substr( fnDoisDigitos($ar['b']) , 0, 1 );
			$arr['c'] = substr( fnDoisDigitos($ar['c']) , 0, 1 );
			$arr['d'] = substr( fnDoisDigitos($ar['d']) , 0, 1 );
			$arr['e'] = substr( fnDoisDigitos($ar['e']) , 0, 1 );
			$arr['f'] = substr( fnDoisDigitos($ar['f']) , 0, 1 );
			$arr['g'] = substr( fnDoisDigitos($ar['g']) , 0, 1 );
//			print_r ($ar);
//echo '<pre>'.print_r($arr, true).'</pre>';

			$arr= array_count_values($arr);
			rsort($arr);
//echo '<pre>'.print_r($arr, true).'</pre>';



			if ($arr[0] > 2){
				// echo PHP_EOL.'<br />'.$count.' '.$ar['a'].' '.$ar['b'].' '.$ar['c'].' '.$ar['d'].' '.$ar['e'].' '.$ar['f'] ;
				$strSQL = "DELETE FROM tbl_SenaJogos7 WHERE cd = ".$ar["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
				$deleted++;
			} 
unset($arr);
		}

		?><p>Foram excluídos <strong><?php echo $deleted; ?></strong> jogos </p><?php 

		break;

	case "mesmo_final":
		$deleted = 0;
		?><h3>Eliminando 3 números com mesmo final </h3><?php 
		$strSQL = " SELECT * FROM tbl_SenaJogos7 ";
		$res = $conn->query($strSQL);

		while($ar = $res->fetch_assoc())
		{
			$arr['a'] = substr( $ar['a'] , -1 );
			$arr['b'] = substr( $ar['b'] , -1 );
			$arr['c'] = substr( $ar['c'] , -1 );
			$arr['d'] = substr( $ar['d'] , -1 );
			$arr['e'] = substr( $ar['e'] , -1 );
			$arr['f'] = substr( $ar['f'] , -1 );
			$arr['g'] = substr( $ar['g'] , -1 );
			
			$arr= array_count_values($arr);
			rsort($arr);



			if ($arr[0] > 2){
				// echo PHP_EOL.'<br />'.$count.' '.$ar['a'].' '.$ar['b'].' '.$ar['c'].' '.$ar['d'].' '.$ar['e'].' '.$ar['f'] ;
				$strSQL = "DELETE FROM tbl_SenaJogos7 WHERE cd = ".$ar["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
				$deleted++;
			} 
unset($arr);
		}

		?><p>FOram excluídos <strong><?php echo $deleted; ?></strong> jogos </p><?php 

		break;

	case "sequencias3":
		$deleted = 0;
		?><h3>Eliminando sequências de  3 números </h3><?php 
		$strSQL = " SELECT * FROM tbl_SenaJogos7 ";
		$res = $conn->query($strSQL);

		while($ar = $res->fetch_assoc())
		{

			$count = countSequencias($ar) ;
			if ($count > 2){
				// echo PHP_EOL.'<br />'.$count.' '.$ar['a'].' '.$ar['b'].' '.$ar['c'].' '.$ar['d'].' '.$ar['e'].' '.$ar['f'] ;
				$strSQL = "DELETE FROM tbl_SenaJogos7 WHERE cd = ".$ar["cd"]." LIMIT 1 ";
				$conn->query($strSQL);
				$deleted++;
			} 
		}

		?><p>FOram excluídos <strong><?php echo $deleted; ?></strong> jogos </p><?php 

		break;

case "primos":

	?><p>Eliminando mais que 3 primos</p><?php 
	$strSQL = " SELECT * FROM tbl_SenaJogos7 ";
	$res = $conn->query($strSQL);
	while($ar = $res->fetch_assoc())
	{
		$primos = 0;
		//if (in_array($arSorteado["num"], $numerosPrimos)){$primos++;}
		$primos += in_array($ar["a"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["b"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["c"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["d"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["e"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["f"], $numerosPrimos) ? 1 : 0;
		$primos += in_array($ar["g"], $numerosPrimos) ? 1 : 0;
		
		//$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
		//$conn->query($strSQL);
		if ($primos > 3){
			$query = "DELETE FROM tbl_SenaJogos7 WHERE cd = {$ar['cd']} LIMIT 1 ";
			$conn->query($query);
			echo PHP_EOL;
			$nrExcluidos++;
		}
		//echo $primos;
	}
	echo '<h2>Primos excluídos: '.$nrExcluidos.'</h2>'.PHP_EOL;
	break;

} // switch
?>
<form method="post">
Filtrar: sequÊncias <input type="hidden" name="f" value="sequencias3"><input type="submit">
</form><br />
<form method="post">
Filtrar: mesmo final <input type="hidden" name="f" value="mesmo_final"><input type="submit">
</form><br />
<form method="post">
Filtrar: mesmo começo <input type="hidden" name="f" value="mesmo_comeco"><input type="submit">
</form><br />
<form method="post">
Filtrar: números primos: <input type="hidden" name="f" value="primos"><input type="submit">
</form>
<hr>
<?php 
if (@$_POST["f"] == "media")
{
	?><p>manter 3/4 pares e 3/4 ímpares</p><?php 
	$strSQL = " SELECT * FROM tbl_SenaJogos ";
	$res = $conn->query($strSQL);
	while($ar = $res->fetch_assoc())
	{
		$nrPares = 0;

		$nrPares += !($ar["a"] % 2) ? 1 : 0;
		$nrPares += !($ar["b"] % 2) ? 1 : 0;
		$nrPares += !($ar["c"] % 2) ? 1 : 0;
		$nrPares += !($ar["d"] % 2) ? 1 : 0;
		$nrPares += !($ar["e"] % 2) ? 1 : 0;
		$nrPares += !($ar["f"] % 2) ? 1 : 0;
		$nrPares += !($ar["g"] % 2) ? 1 : 0;
		
		//$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
		//$conn->query($strSQL);
		if ($nrPares <> 3 && $nrPares <> 4){
			$query = "DELETE FROM tbl_SenaJogos7 WHERE cd = {$ar['cd']} LIMIT 1 ";
			$conn->query($query);
		echo $nrPares;
		}
	}

}


?>
<form method="post">
Filtrar: manter 3/4 pares e 3/4 ímparess: <input type="hidden" name="f" value="media"><input type="submit">
</form>
<br><br>
<p>
Jogos: <strong><?php 
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos7";
$res = $conn->query($strSQL);
var_dump($res->fetch_assoc());
?></strong>
</p>
<?php  include_once("lib.footer.php") ?>
</body>
</html>
