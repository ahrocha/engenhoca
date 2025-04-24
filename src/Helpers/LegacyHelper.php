<?php

namespace App\Helpers;

use App\Core\DatabaseService;

class LegacyHelper
{
    public static $conn;

    public static function getConnection()
    {
        $conn = DatabaseService::getConnection();
        return $conn;
    }
    public static function getNumerosPrimos(): array
    {
        return [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59];
    }

    public static function lastTop10($sorteioInicial = 0, $sorteioFinal = 0)
    {
        $conn = self::getConnection();
        $strSQL = "SELECT num, COUNT(*) AS total FROM tbl_Sena WHERE jogo > $sorteioInicial and jogo < $sorteioFinal GROUP BY num ORDER BY total DESC ";
        $result = $conn->query($strSQL);
        $return = [];
        $i = 0;
        while ($sorteio = $result->fetch()) {
            $return[] = $sorteio['num'];
            $i++;
            if ($i == 10) {
                break;
            }
        }
        return $return;
    }

    public static function obterSorteioEspecifico($jogo)
    {
        $conn = self::getConnection();
        $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$jogo." ORDER BY num ";
        $result = $conn->query($strSQL);

        $return = [];
        $i = 0;
        while ($sorteio = $result->fetch()) {
            $return[] = $sorteio;
            $i++;
            if ($i == 10) {
                break;
            }
        }
        return $return;
    }

    public static function endsWithSameDigit($array, $limit = 2)
    {
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


    public static function fnSena($cdJogo)
    {
        $conn = self::getConnection();
        $strSQL = "SELECT * FROM tbl_Sena WHERE jogo = $cdJogo";
        $result = $conn->query($strSQL);
        $result = $result->fetchAll(MYSQLI_ASSOC);

        foreach ($result as $array) {
            $arSorteados[] = $array["num"];
        }
        return $arSorteados;
    }

    public static function getUltimoJogo()
    {
        $conn = self::getConnection();
        $strSQL = "SELECT MAX(jogo) as jogo FROM tbl_Sena";
        $result = $conn->query($strSQL);
        $result = $result->fetch();
        return $result['jogo'];
    }

    public static function snUltimosJogos($numero)
    {
        $conn = self::getConnection();
        $nrUltimo = self::getUltimoJogo();

        $nrDezAtras = $nrUltimo - 10;
        $strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".$nrDezAtras ." AND num = ".$numero;
        $resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetchAll();
        return count($resTemp) > 0;
    }
    public static function snUltimoJogo($numero)
    {
        $nrUltimo = self::getUltimoJogo();
        $conn = self::getConnection();
        $strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".$nrUltimo." AND num = ".$numero;

        $resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetchAll();
        return count($resTemp) > 0;
    }
    public static function snPenultimoJogo($numero)
    {
        global $nrUltimo, $conn;
        $strSQL = "SELECT COUNT(*) FROM tbl_Sena WHERE jogo >= ".($nrUltimo - 1)." AND num = ".$numero;

        $resTemp = $conn->query($strSQL);
        $resTemp = $resTemp->fetchAll();
        return count($resTemp) > 0;
    }

    public static function printNumero(&$esteNumero)
    {
        $esteNumero = fnDoisDigitos($esteNumero);
    }

    public static function fnDoisDigitos($a)
    {
        $a = trim($a);
        if (strlen($a) >= 2) {
            return $a;
        }
        return "0$a";
    }

    public static function fnInsereTrio($a, $b, $c)
    {
        $conn = self::getConnection();
        $strSQL = "SELECT * FROM tbl_SenaTrios WHERE a = $a AND b = $b AND c = $c";
        $resultIT = $conn->query($strSQL);
        if ($resultIT->rowCount() > 0) {
            $thisResult = $resultIT->fetch();
            $strSQL = "UPDATE tbl_SenaTrios SET nr = nr + 1 WHERE cd = ".$thisResult['cd'];
        } else {
            $strSQL = "INSERT into tbl_SenaTrios (a,b,c,nr) VALUES ($a,$b,$c,1)";
        }
        $conn->query($strSQL);
    }

    public static function fnVariosJogos($jogoso)
    {
        $conn = self::getConnection();
        if (strlen($jogoso) > 0) {
            $num = explode(";", $jogoso);

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
            fnInsereTrio($a, $b, $c);
            fnInsereTrio($a, $b, $d);
            fnInsereTrio($a, $b, $e);
            fnInsereTrio($a, $b, $f);
            fnInsereTrio($a, $c, $d);
            fnInsereTrio($a, $c, $e);
            fnInsereTrio($a, $c, $f);
            fnInsereTrio($a, $d, $e);
            fnInsereTrio($a, $d, $f);
            fnInsereTrio($b, $c, $d);
            fnInsereTrio($b, $c, $e);
            fnInsereTrio($b, $c, $f);
            fnInsereTrio($b, $d, $e);
            fnInsereTrio($b, $d, $f);
            fnInsereTrio($c, $d, $e);
            fnInsereTrio($c, $d, $f);
            fnInsereTrio($d, $e, $f);

            fnInsereDupla($a, $b);
            fnInsereDupla($a, $c);
            fnInsereDupla($a, $d);
            fnInsereDupla($a, $e);
            fnInsereDupla($a, $f);
            fnInsereDupla($b, $c);
            fnInsereDupla($b, $d);
            fnInsereDupla($b, $e);
            fnInsereDupla($b, $f);
            fnInsereDupla($c, $d);
            fnInsereDupla($c,$e);
            fnInsereDupla($c,$f);
            fnInsereDupla($d,$e);
            fnInsereDupla($d,$f);
            fnInsereDupla($e,$f);

        }
    }

}
