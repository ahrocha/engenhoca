<?php

function lastTop10($sorteioInicial = 0, $sorteioFinal = 0) {
    global $conn;
    $strSQL = "SELECT num, COUNT(*) AS total FROM tbl_Sena WHERE jogo > $sorteioInicial and jogo < $sorteioFinal GROUP BY num ORDER BY total DESC ";
    $result = $conn->query($strSQL);
    $return = [];
    $i = 0;
    while($sorteio = $result->fetch_assoc()) {
        $return[] = $sorteio['num'];
        $i++;
        if ($i == 10) {
            break;
        }
    }
    return $return;
}

function obterSorteioEspecifico($jogo) {
    global $conn;
    $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$jogo." ORDER BY num ";
    $result = $conn->query($strSQL);

    $return = [];
    $i = 0;
    while($sorteio = $result->fetch_assoc()) {
        $return[] = $sorteio;
        $i++;
        if ($i == 10) {
            break;
        }
    }
    return $return;
}

function endsWithSameDigit($array, $limit = 2) {
    // Check if the array has exactly six elements
    if (count($array) !== 6) {
        echo PHP_EOL . __LINE__ . PHP_EOL;
        return false;
    }

    // Create an array to count occurrences of each last digit
    $lastDigitCounts = array_fill(0, 10, 0); // Initializes an array with 10 elements (0-9) set to 0

    // Iterate through the array and count the last digits
    foreach ($array as $value) {
        $lastDigit = $value % 10; // Extract the last digit
        $lastDigitCounts[$lastDigit]++;
    }

    // Check if any last digit appears at least $limit times
    foreach ($lastDigitCounts as $count) {
        if ($count > $limit) {
            echo PHP_EOL . __LINE__ . PHP_EOL;
            return true;
        }
    }
    echo PHP_EOL . __LINE__ . PHP_EOL;

    return false;
}


function fnSena($cdJogo)
{
	global $conn;
	$strSQL = "SELECT * FROM tbl_Sena WHERE jogo = $cdJogo";
	$result = $conn->query($strSQL);
  $result = $result->fetch_all(MYSQLI_ASSOC);

	foreach($result as $array)
	{
		$arSorteados[] = $array["num"];
	}
	return $arSorteados;
}


function snUltimosJogos($numero)
{
	global $nrAntepenultimo, $nrPenultimo, $nrUltimo, $conn;
	$nrDezAtras = $nrUltimo - 10; 
	$strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".$nrPenultimo." AND num = ".$numero;
	$strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".$nrDezAtras ." AND num = ".$numero;
	//echo $strSQL;
	$resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetch_all();
	if($resTemp->num_rows > 0){ return true;}else{return false;}
}
function snUltimoJogo($numero)
{
	global $nrUltimo, $conn;
	$strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".$nrUltimo." AND num = ".$numero;
	//echo $strSQL;
	$resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetch_all();
	if($resTemp->num_rows > 0){ return true;}else{return false;}
}
function snPenultimoJogo($numero)
{
	global $nrUltimo, $conn;
	$strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".($nrUltimo-1)." AND num = ".$numero;

	$resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetch_all();
	if($resTemp->num_rows > 0){ return true;}else{return false;}
}

function printNumero( &$esteNumero ){
	$esteNumero = fnDoisDigitos($esteNumero);
}
