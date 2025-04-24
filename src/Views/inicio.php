<?php if ($this->securityService->isAllowed()) { ?>
    <h2>Incluir jogos</h2>
    <p>Formato: <br />
    jogo;a;b;c;d;e;f; <br />
    Exemplo: <br />
    1234;1;2;22;33;44;55;
    <form method="post" action="inicio.php">
        <textarea name="values" id="values" size="300" style='width:400px; height:150px'></textarea>
    <input type="submit" name="Submit" value="Incluir">
    <input name="frmFuncao" type="hidden" id="frmFuncao" value="IncluirVariosSorteio">
    </form>

    <hr />
<?php } ?>

<?php if (isset($top10) && !empty($top10)) : ?>
<h2>Top 10 histórico</h2>
<?php
echo implode(" ", $top10);
    ?>
<?php endif; ?>

<?php if (isset($recentTop10) && !empty($recentTop10)) : ?>
<h2>Top 10 últimos sorteios</h2>
<?php
    echo implode(" ", $recentTop10);
    ?>
<?php endif; ?>

<?php if (isset($ultimos20Sorteios) && !empty($ultimos20Sorteios)) : ?>
  <h2>Últimos 20 sorteios</h2>

  <table  class="table">
<tr>
<th>#</th>
<th>#1</th>
<th>#2</th>
<th>#3</th>
<th>#4</th>
<th>#5</th>
<th>#6</th>
<?php if ($this->securityService->isAllowed()) { ?>
<th>excluir</th>
<?php } ?>
<th>rep 2 ants</th>
<th>rep</th>
<th>top10</th>
<th>lasttop10</th>
<th>primos</th>
<th>40+</th>
<th>pares</th>
</tr>
<?php
    $dezenas = array("01a10" => 0, "11a20" => 0, "21a30" => 0, "31a40" => 0, "41a50" => 0, "51a60" => 0);
    $doisAnteriores = [];
    $arAnterior = [];

    foreach ($ultimos20Sorteios as $arSorteio) {
        $lastTop10 = App\Helpers\LegacyHelper::lastTop10($arSorteio["jogo"] - 10, $arSorteio["jogo"]);
        $proximojogo = $arSorteio["jogo"] + 1;
        echo "<tr>";
        echo "<td>".$arSorteio["jogo"]."</td>".PHP_EOL;

        $resSorteado = App\Helpers\LegacyHelper::obterSorteioEspecifico($arSorteio["jogo"]);
        $maiorquarenta = 0;
        $pares = 0;
        $rep = 0;
        $primos = 0;
        $isTop10 = 0;
        $isLastTop10 = 0;
        $repetidosDoisAnteriores = [];

        foreach ($resSorteado as $arSorteado) {
            $arEste[] = $arSorteado["num"];
            if ($arSorteado["num"] > 40) {
                $maiorquarenta++;
            }
            if (($arSorteado["num"] % 2) == 0) {
                $pares++;
            }
            if (in_array($arSorteado["num"], $arAnterior)) {
                $rep++;
            }
            if (in_array($arSorteado["num"], $numerosPrimos)) {
                $primos++;
            }
            if (in_array($arSorteado["num"], $top10)) {
                $isTop10++;
            }
            if (in_array($arSorteado["num"], $lastTop10)) {
                $isLastTop10++;
            }
            if ($arSorteado["num"] < 11) {
                $dezenas["01a10"]++;
            } elseif ($arSorteado["num"] < 21) {
                $dezenas["11a20"]++;
            } elseif ($arSorteado["num"] < 31) {
                $dezenas["21a30"]++;
            } elseif ($arSorteado["num"] < 41) {
                $dezenas["31a40"]++;
            } elseif ($arSorteado["num"] < 51) {
                $dezenas["41a50"]++;
            } elseif ($arSorteado["num"] < 61) {
                $dezenas["51a60"]++;
            }
            echo "<td>";
            if (in_array($arSorteado["num"], $doisAnteriores)) {
                $repetidosDoisAnteriores[] = $arSorteado["num"];
                echo "<b>";
            }
            echo $arSorteado["num"];
            if (in_array($arSorteado["num"], $doisAnteriores)) {
                echo "</b>";
            }
            echo "</td>".PHP_EOL;
        }
        $doisAnteriores = $arAnterior;
        $arAnterior = $arEste;
        unset($arEste);
        if ($this->securityService->isAllowed()) {
            echo "<td><a href=\"inicio.php?excluir=".$arSorteio["jogo"]."\">excluir</a></td>".PHP_EOL;
        }

        echo "<td>".implode(" ", $repetidosDoisAnteriores)."</td>".PHP_EOL;
        echo "<td> $rep </td>".PHP_EOL;
        echo "<td> $isTop10 </td>".PHP_EOL;
        echo "<td> $isLastTop10 </td>".PHP_EOL;
        echo "<td> $primos </td>".PHP_EOL;
        echo "<td> $maiorquarenta </td>".PHP_EOL;
        echo "<td> $pares </td>".PHP_EOL;
        echo "</tr>";
        $ultimoSorteio = $arSorteio["jogo"];
    }

?>
</table>

<?php endif; ?>