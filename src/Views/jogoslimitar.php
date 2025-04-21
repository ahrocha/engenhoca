<form method="post">

<br>
Qtdd de jogos: <input type="text" name="qtdd" value="100">
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

    case "segundo_maior_que_dez":

        ?>
        <h3>Eliminando quando há 2 números menores ou iguais 10. </h3><?php 
        $strSQL = "SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "Inicial: " . $ar["nrTotal"] .'<br />';

        $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos WHERE b <= 10 ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "> 10: " . $ar["nrTotal"].'<br />';

        $strSQL = "DELETE FROM tbl_SenaJogos WHERE b <= 10 ";
        $conn->query($strSQL);

        $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "Resultados: " . $ar["nrTotal"] .'<br />';

        break;

        case "terceiro_maior_que_dez":
    
            ?>
            <h3>Eliminando quando há 3 números menores ou iguais 10. </h3><?php 
            $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
            $res = $conn->query($strSQL);
            $ar = $res->fetch_array();
            echo "Inicial: " . $ar["nrTotal"] .'<br />';
    
            $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos WHERE c <= 10 ";
            $res = $conn->query($strSQL);
            $ar = $res->fetch_array();
            echo "> 10: " . $ar["nrTotal"].'<br />';
    
            $strSQL = "DELETE FROM tbl_SenaJogos WHERE c <= 10 ";
            $conn->query($strSQL);
    
            $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
            $res = $conn->query($strSQL);
            $ar = $res->fetch_array();
            echo "Resultados: " . $ar["nrTotal"] .'<br />';
    
            break;

    case "um_digito":

        ?><h3>Eliminando quando não há nenhum número menor ou igual a 10. </h3><?php 
        $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "Inicial: " . $ar["nrTotal"] .'<br />';

        $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos WHERE a > 10 ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "> 10: " . $ar["nrTotal"].'<br />';

        $strSQL = "DELETE FROM tbl_SenaJogos WHERE a > 10 ";
        $conn->query($strSQL);

        $strSQL = " SELECT COUNT(*) as nrTotal FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "Resultados: " . $ar["nrTotal"] .'<br />';

        break;

    case "mesmo_final":
        $deleted = 0;
        ?><h3>Eliminando 3 números com mesmo final </h3><?php
        $strSQL = " SELECT * FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);

        $executar = $_POST["acao"] == "executar";

        while($ar = $res->fetch_array())
        {
            $array = array($ar["a"], $ar["b"], $ar["c"], $ar["d"], $ar["e"], $ar["f"]);

            if (endsWithSameDigit($array, 2)) {
                $deleted++;
                if(!$executar){
                    continue;
                }
                $strSQL = "DELETE FROM tbl_SenaJogos WHERE cd = ".$ar["cd"]." LIMIT 1 ";
                $conn->query($strSQL);
            }

            unset($array);
            unset($ar);
        }
        
        if ($executar) {
            echo "<p>Foram excluídos <strong>$deleted</strong> jogos.</p>";
        } else {
            echo "<p>Serão excluídos <strong>$deleted</strong> jogos.</p>";
        }

        break;

    case "sequencias3":
        $deleted = 0;
        ?><h3>Eliminando sequências de  3 números </h3><?php 
        $strSQL = " SELECT * FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);

        while($ar = $res->fetch_array())
        {

            $count = countSequencias($ar) ;
            if ($count > 2){
                $strSQL = "DELETE FROM tbl_SenaJogos WHERE cd = ".$ar["cd"]." LIMIT 1 ";
                $conn->query($strSQL);
                $deleted++;
            } 
        }

        ?><p>FOram excluídos <strong><?php echo $deleted; ?></strong> jogos </p><?php 

        break;

    case "media":

        ?><p>Eliminando médias < 10 e média > 45</p><?php 
        $strSQL = " SELECT * FROM tbl_SenaJogos ";
        $res = $conn->query($strSQL);
        while($ar = $res->fetch_array())
        {
            $soma = $ar["a"] + $ar["b"] + $ar["c"] + $ar["d"] + $ar["e"] + $ar["f"] ;
            $media = floor($soma / 6) ;
            $strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
            $conn->query($strSQL);
        }
        $strSQL = "DELETE FROM tbl_SenaJogos WHERE media < 10";
        $res = $conn->query($strSQL);
        echo "Apagadas menores que 10: ".$conn->affected_rows;
        $strSQL = "DELETE FROM tbl_SenaJogos WHERE media > 45";
        $res = $conn->query($strSQL);
        echo "Apagadas maiores que 45: ".$conn->affected_rows;

        break;

case "primos":

    ?><p>Eliminando mais que 3 primos</p><?php 
    $strSQL = " SELECT * FROM tbl_SenaJogos ";
        // $resSorteios = $conn->query($strSQL);
        // while($arSorteio = $resSorteios->fetch_array())
    $res = $conn->query($strSQL);
    while($ar = $res->fetch_array())
    {
        $primos = 0;
        //if (in_array($arSorteado["num"], $numerosPrimos)){$primos++;}
        $primos += in_array($ar["a"], $numerosPrimos) ? 1 : 0;
        $primos += in_array($ar["b"], $numerosPrimos) ? 1 : 0;
        $primos += in_array($ar["c"], $numerosPrimos) ? 1 : 0;
        $primos += in_array($ar["d"], $numerosPrimos) ? 1 : 0;
        $primos += in_array($ar["e"], $numerosPrimos) ? 1 : 0;
        $primos += in_array($ar["f"], $numerosPrimos) ? 1 : 0;
        
        //$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
        //$conn->query($strSQL);
        if ($primos >= 3){
            $query = "DELETE FROM tbl_SenaJogos WHERE cd = {$ar['cd']} LIMIT 1 ";
            $conn->query($query);
            // echo '<hr>'.PHP_EOL.$primos.PHP_EOL;
            // echo PHP_EOL;
            $nrExcluidos++;
        }
        //echo $primos;
    }
    echo '<h2>Primos excluídos: '.$nrExcluidos.'</h2>'.PHP_EOL;
    break;

    case "combinacoes_1x1x1x1x1x1":
      $where = '
                a <= 10
                AND b > 10 AND b <=20
                AND c > 20 AND c <=30
                AND d > 30 AND d <=40
                AND e > 40 AND e <=50
                AND f > 50';
        $strSQL = "
            SELECT COUNT(*) as nrTotal
            FROM tbl_SenaJogos 
            WHERE $where
            ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "combinacoes_1x1x1x1x1x1: " . $ar["nrTotal"].'<br />';
        if ($_POST["acao"] == "executar") {
            $query = "
                DELETE FROM tbl_SenaJogos 
                WHERE $where
            ";
            $results = $conn->query($query);
            var_dump($results);
        }

        break;

        case "2_dezena_acima_50":
          $where = '
                    f >= 50
                    AND e >= 50
                    AND d >= 50';
            $strSQL = "
                SELECT COUNT(*) as nrTotal
                FROM tbl_SenaJogos
                WHERE $where
                ";
            $res = $conn->query($strSQL);
            $ar = $res->fetch_array();
            echo "2_dezena_acima_50: " . $ar["nrTotal"].'<br />';
            if ($_POST["acao"] == "executar") {
                $query = "
                    DELETE FROM tbl_SenaJogos
                    WHERE $where
                ";
                $results = $conn->query($query);
                var_dump($results);
            }
            if ($_POST["acao"] == "ver") {
                $query = "
                    SELECT a,b,c,d,e,f FROM tbl_SenaJogos 
                    WHERE $where
                ";
                $results = $conn->query($query);
                echo "<pre>$query</pre>";
                while($ar = $results->fetch_array()) {
                    echo $ar['a'] . ' ' . $ar['b'] . ' ' . $ar['c'] . ' ' . $ar['d'] . ' ' . $ar['e'] . ' ' . $ar['f'] . ' <br />' . PHP_EOL; 
                }
            }
    
            break;

            case "1_dezena_acima_50":
              $where = '
                        f < 50
                        OR e >= 50
                        OR d >= 50
                        OR c >= 50
                        OR b >= 50
                        OR a >= 50';
                $strSQL = "
                    SELECT COUNT(*) as nrTotal
                    FROM tbl_SenaJogos
                    WHERE $where
                    ";
                $res = $conn->query($strSQL);
                $ar = $res->fetch_array();
                echo "1_dezena_acima_50: " . $ar["nrTotal"].'<br />';
                if ($_POST["acao"] == "executar") {
                    $query = "
                        DELETE FROM tbl_SenaJogos
                        WHERE $where
                    ";
                    $results = $conn->query($query);
                    var_dump($results);
                }
                if ($_POST["acao"] == "ver") {
                    $query = "
                        SELECT a,b,c,d,e,f FROM tbl_SenaJogos 
                        WHERE $where
                    ";
                    $results = $conn->query($query);
                    echo "<pre>$query</pre>";
                    while($ar = $results->fetch_array()) {
                        echo $ar['a'] . ' ' . $ar['b'] . ' ' . $ar['c'] . ' ' . $ar['d'] . ' ' . $ar['e'] . ' ' . $ar['f'] . ' <br />' . PHP_EOL; 
                    }
                }
        
                break;

    case "primeiro_maior_que_20":
      $where = '
                a > 20';
        $strSQL = "
            SELECT COUNT(*) as nrTotal
            FROM tbl_SenaJogos 
            WHERE $where
            ";
        $res = $conn->query($strSQL);
        $ar = $res->fetch_array();
        echo "primeiro_maior_que_20: " . $ar["nrTotal"].'<br />';
        if ($_POST["acao"] == "executar") {
            $query = "
                DELETE FROM tbl_SenaJogos 
                WHERE $where
            ";
            $results = $conn->query($query);
            var_dump($results);
        }
        if ($_POST["acao"] == "ver") {
            $query = "
                SELECT a,b,c,d,e,f FROM tbl_SenaJogos 
                WHERE $where
            ";
            $results = $conn->query($query);
            echo "<pre>$query</pre>";
            while($ar = $results->fetch_array()) {
                echo $ar['a'] . ' ' . $ar['b'] . ' ' . $ar['c'] . ' ' . $ar['d'] . ' ' . $ar['e'] . ' ' . $ar['f'] . ' <br />' . PHP_EOL; 
            }
        }

        break;

} // switch
?>




<form method="post">
    Filtrar: mesmo final
    <input type="hidden" name="f" value="mesmo_final">
    <input type="submit" name="acao" value="previsao">
    <input type="submit" name="acao" value="executar">
    Somente jogos que possuem exatamente 2 jogos com o mesmo final permanecerão.
</form><br /><br />

<form method="post">
    Filtrar quando primeiro número é maior que 20:
    <input type="hidden" name="f" value="primeiro_maior_que_20">
    <input type="submit" name="acao" value="previsao">
    <input type="submit" name="acao" value="executar">
</form><br />


<form method="post">
    Filtrar combinações 1x1x1x1x1x1:
    <input type="hidden" name="f" value="combinacoes_1x1x1x1x1x1">
    <input type="submit" name="acao" value="previsao">
    <input type="submit" name="acao" value="executar">
</form><br />


<form method="post">
    Deixar até 2 dezenas acima de 50:
    <input type="hidden" name="f" value="2_dezena_acima_50">
    <input type="submit" name="acao" value="previsao">
    <input type="submit" name="acao" value="executar">
    <input type="submit" name="acao" value="ver">
</form><br />


<form method="post">
Filtrar: eliminar jogos com 3 números menores ou iguais a 10: <input type="hidden" name="f" value="terceiro_maior_que_dez"><input type="submit">
</form><br />

<hr />

<form method="post">
    Deixar somente 1 dezena acima de 50:
    <input type="hidden" name="f" value="1_dezena_acima_50">
    <input type="submit" name="acao" value="previsao">
    <input type="submit" name="acao" value="executar">
    <input type="submit" name="acao" value="ver">
</form><br />

<form method="post">
Filtrar: eliminar jogos com 2 números menores ou iguais a 10: <input type="hidden" name="f" value="segundo_maior_que_dez"><input type="submit">
</form><br />


<form method="post">
Filtrar: somente jogos com pelo menos 1 número menor ou igual a 10: <input type="hidden" name="f" value="um_digito"><input type="submit">
</form><br />

<form method="post">
Filtrar: manter média entre 10 e 45: <input type="hidden" name="f" value="media"><input type="submit">
</form><br />

<form method="post">
Filtrar: sequÊncias de 3 <input type="hidden" name="f" value="sequencias3"><input type="submit">
</form><br />

<form method="post">
Filtrar: números primos: <input type="hidden" name="f" value="primos"><input type="submit">
</form>
<hr>
<?php
if (@$_POST["f"] == "media")
{
    ?><p>manter 3 pares e 3 ímpares</p><?php 
    $strSQL = " SELECT * FROM tbl_SenaJogos ";
    $res = $conn->query($strSQL);
    while($ar = $res->fetch_array())
    {
        $nrPares = 0;

        $nrPares += !($ar["a"] % 2) ? 1 : 0;
        $nrPares += !($ar["b"] % 2) ? 1 : 0;
        $nrPares += !($ar["c"] % 2) ? 1 : 0;
        $nrPares += !($ar["d"] % 2) ? 1 : 0;
        $nrPares += !($ar["e"] % 2) ? 1 : 0;
        $nrPares += !($ar["f"] % 2) ? 1 : 0;
        
        //$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
        //$conn->query($strSQL);
        if ($nrPares <> 3){
            $query = "DELETE FROM tbl_SenaJogos WHERE cd = {$ar['cd']} LIMIT 1 ";
            $conn->query($query);
        }
        echo $nrPares;
    }

}

if (@$_POST["f"] == "4224")
{
    ?><p>manter 2~4 pares e 4~2 ímpares</p><?php 
    $strSQL = " SELECT * FROM tbl_SenaJogos ";
    $res = $conn->query($strSQL);
    while($ar = $res->fetch_array())
    {
        $nrPares = 0;

        $nrPares += !($ar["a"] % 2) ? 1 : 0;
        $nrPares += !($ar["b"] % 2) ? 1 : 0;
        $nrPares += !($ar["c"] % 2) ? 1 : 0;
        $nrPares += !($ar["d"] % 2) ? 1 : 0;
        $nrPares += !($ar["e"] % 2) ? 1 : 0;
        $nrPares += !($ar["f"] % 2) ? 1 : 0;
        
        //$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
        //$conn->query($strSQL);
        if ( $nrPares == 0 ||  $nrPares == 1 ||  $nrPares == 5 || $nrPares == 6 ){
            $query = "DELETE FROM tbl_SenaJogos WHERE cd = {$ar['cd']} LIMIT 1 ";
            $conn->query($query);
        }
        echo $nrPares;
    }

}

if (@$_POST["f"] == "maior40")
{
    ?><p>até 2 números maiores que 40</p><?php 
    $strSQL = " SELECT * FROM tbl_SenaJogos ";
    $res = $conn->query($strSQL);
    $nrExcluidos = 0;
    while($ar = $res->fetch_array())
    {
        $nrQtdd = 0;

        $nrQtdd += ($ar["a"] > 40) ? 1 : 0;
        $nrQtdd += ($ar["b"] > 40) ? 1 : 0;
        $nrQtdd += ($ar["c"] > 40) ? 1 : 0;
        $nrQtdd += ($ar["d"] > 40) ? 1 : 0;
        $nrQtdd += ($ar["e"] > 40) ? 1 : 0;
        $nrQtdd += ($ar["f"] > 40) ? 1 : 0;
        
        //$strSQL = "UPDATE tbl_SenaJogos SET media = $media WHERE cd = ".$ar["cd"]." LIMIT 1 ";
        //$conn->query($strSQL);
        if ($nrQtdd > 2){
            $query = "DELETE FROM tbl_SenaJogos WHERE cd = {$ar['cd']} LIMIT 1 ";
            $conn->query($query);
            $nrExcluidos++;
        }
        echo $nrPares;
    }
    echo PHP_EOL."<p>Foram excluidos <strong>$nrExcluidos</strong> jogos</p>".PHP_EOL;
}
?>
<form method="post">
Filtrar: manter 3 pares e 3 ímparess: <input type="hidden" name="f" value="media"><input type="submit">
</form>
<br><br>
<form method="post">
Filtrar: manter 2~4 pares e 4~2 ímpares: <input type="hidden" name="f" value="4224"><input type="submit">
</form>
<br><br>
<form method="post">
Filtrar: limitar a 2 dezenas maiores que 40 <input type="hidden" name="f" value="maior40"><input type="submit">
</form>
<br><br>
<p>
Jogos: <strong><?php 
$strSQL = "SELECT COUNT(*) FROM tbl_SenaJogos";
$res = $conn->query($strSQL);
