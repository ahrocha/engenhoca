<?php

include_once("header.php");
require_once "../lib/lib.inc.comum.php";

$strSQL = "SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC LIMIT 1";

$numeros1a60 = range(1, 60);

$res = $conexao->select($strSQL);
$nrUltimo = $res[0]["jogo"];

$exibidos = 0;
$exibir = 20;
$limit = 100;

if ($_GET["gerar-csv"] === 'sim') {
    $limit = 3000;
    $csvFilename = 'pepe_'.$nrUltimo . '.csv';
}
$csv = [];

function escolhe_itens_aleatorios($array, $numero_de_itens) {
    $chaves_aleatorias = array_rand($array, $numero_de_itens);
    $itens_aleatorios = [];

    // Se $numero_de_itens for 1, array_rand retorna uma chave única, não um array
    if ($numero_de_itens === 1) {
        $itens_aleatorios[] = $array[$chaves_aleatorias];
    } else {
        foreach ($chaves_aleatorias as $chave) {
            $itens_aleatorios[] = $array[$chave];
        }
    }

    return $itens_aleatorios;
}

for ($i = 0; $i < $limit; $i++) {
    $sorteio = $nrUltimo - $i;
    if ($sorteio < 10) break;
    $proximo = $sorteio + 1;
    $nrCincoAtras = $sorteio - 5;
    $nrDezAtras = $sorteio - 10;

    $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = $proximo";
    $result = $conn->query($strSQL);

    $sorteadosProximo = array();
    while($row = $result->fetch_assoc()) {
        $sorteadosProximo[] = $row['num'];
    }

    $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = $sorteio";
    $result = $conn->query($strSQL);
    $sorteadosAtual = array();
    while($row = $result->fetch_assoc()) {
        $sorteadosAtual[] = $row['num'];
    }

    // números que saíram nos últimos 10 sorteios
    $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo > $nrDezAtras and jogo <= $sorteio GROUP BY num; ";
    $result = $conn->query($strSQL);
    $numerosSorteadosUmaVezDezUltimos = [];
    $numerosSorteadosDuasVezesDezUltimos = [];
    $numerosSorteadosQuatroVezesDezUltimos = [];
    while($array = $result->fetch_assoc())
    {
        $numerosSorteadosUmaVezDezUltimos[] = $array["cd"];
        if ($array["qtdd_ultimas"] >= 2){
            $numerosSorteadosDuasVezesDezUltimos[] = $array["cd"];
        }
        if ($array["qtdd_ultimas"] >= 4){
            $numerosSorteadosQuatroVezesDezUltimos[] = $array["cd"];
        }
    }

    // $numerosSorteadosUmaVezCincoUltimos
    $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo > $nrCincoAtras and jogo <= $sorteio GROUP BY num; ";

    $result = $conn->query($strSQL);
    $numerosSorteadosUmaVezCincoUltimos = [];
    $numerosSorteadosTresVezesCincoUltimos = [];
    while($array = $result->fetch_assoc())
    {
        $numerosSorteadosUmaVezCincoUltimos[] = $array["cd"];
        if ($array["qtdd_ultimas"] >= 3){
            $numerosSorteadosTresVezesCincoUltimos[] = $array["cd"];
        }
    }

    // $numerosSorteadosUmaVezCincoPenultimos
    $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo <= $nrCincoAtras AND jogo > $nrDezAtras GROUP BY num; ";

    $result = $conn->query($strSQL);
    $numerosSorteadosUmaVezCincoPenultimos = [];
    while($array = $result->fetch_assoc())
    {
        $numerosSorteadosUmaVezCincoPenultimos[] = $array["cd"];
    }

    $grupoUm = array_intersect($numerosSorteadosUmaVezCincoUltimos, $numerosSorteadosDuasVezesDezUltimos);
    // $grupoUm = array_diff($grupoUm, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosTresVezesCincoUltimos);
    $sorteadosGrupoUm = array_intersect($grupoUm, $sorteadosProximo);
    
    $grupoDois = array_diff(array_intersect($numerosSorteadosUmaVezDezUltimos, $numerosSorteadosUmaVezCincoUltimos), $grupoUm);
    $grupoDois = array_diff($grupoDois, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosTresVezesCincoUltimos);
    $sorteadosGrupoDois = array_intersect($grupoDois, $sorteadosProximo);
    
    $grupoTres = array_diff(array_intersect($numerosSorteadosUmaVezDezUltimos, $numerosSorteadosUmaVezCincoPenultimos), $grupoUm, $grupoDois);
    $grupoTres = array_diff($grupoTres, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosTresVezesCincoUltimos);
    $sorteadosGrupoTres = array_intersect($grupoTres, $sorteadosProximo);
    
    $grupoQuatro = array_diff($numeros1a60, $grupoUm, $grupoDois, $grupoTres);
    $grupoQuatro = array_diff($grupoQuatro, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosTresVezesCincoUltimos);
    $sorteadosGrupo4 = array_intersect($grupoQuatro, $sorteadosProximo);

    $saidaSorteadosAtual = [];
    foreach ($sorteadosAtual as $sorteado) {
        if (in_array($sorteado, $grupoUm)) {
            $saidaSorteadosAtual[] = $sorteado . ' (1)';
        }
        if (in_array($sorteado, $grupoDois)) {
            $saidaSorteadosAtual[] = $sorteado . ' (2)';
        }
        if (in_array($sorteado, $grupoTres)) {
            $saidaSorteadosAtual[] = $sorteado . ' (3)';
        }
        if (in_array($sorteado, $grupoQuatro)) {
            $saidaSorteadosAtual[] = $sorteado . ' (4)';
        }
    }

    $saidaSorteadosProximo = [];
    foreach ($sorteadosProximo as $sorteado) {
        if (in_array($sorteado, $grupoUm)) {
            $saidaSorteadosProximo[] = $sorteado . ', (g1)';
        }
        if (in_array($sorteado, $grupoDois)) {
            $saidaSorteadosProximo[] = $sorteado . ', (g2)';
        }
        if (in_array($sorteado, $grupoTres)) {
            $saidaSorteadosProximo[] = $sorteado . ', (g3)';
        }
        if (in_array($sorteado, $grupoQuatro)) {
            $saidaSorteadosProximo[] = $sorteado . ', (g4)';
        }
    }

    $todosOs60 = [];
    foreach (range(1, 60) as $num) {
        if (in_array($num, $grupoUm)) {
            $todosOs60[] = $num . ', (g1)';
        } elseif (in_array($num, $grupoDois)) {
            $todosOs60[] = $num . ', (g2)';
        } elseif (in_array($num, $grupoTres)) {
            $todosOs60[] = $num . ', (g3)';
        } elseif (in_array($num, $grupoQuatro)) {
            $todosOs60[] = $num . ', (g4)';
        } else {
            $todosOs60[] = $num . ', (g5)';
        }
    }

    if ($exibidos < $exibir) {
        $exibidos++;

    ?>
    <div style="border: 1px solid pink; padding: 5px; width: 100%;">
    <?php

    echo '<h2>Números até o sorteio ' . $sorteio . ' para jogar no '.$proximo.'</h2>';

    // if exists 'pepe_'.$nrUltimo . '.csv' , generate a link to download it
    if (file_exists("../csv/pepe_$sorteio.csv")) {
        echo '<a href="../csv/pepe_'.$sorteio.'.csv">Baixar CSV</a>';
    } else if ($nrUltimo == $sorteio && $_GET["gerar-csv"] !== 'sim') {
        echo '<a href="?gerar-csv=sim">Gerar CSV</a>';
    }

    echo '<p>Resultados do sorteio seguinte: ('.$proximo.') - ' . implode(' | ', $saidaSorteadosProximo) . '</p>';
    ?>
    
        <p>Numeros Sorteados Quatro Vezes Dez Ultimos (<?php echo count($numerosSorteadosQuatroVezesDezUltimos); ?>): <?php echo implode(' ', $numerosSorteadosQuatroVezesDezUltimos); ?></p>
        <p>Numeros sorteados três vezes 5 últimos (<?php echo count($numerosSorteadosTresVezesCincoUltimos); ?>): <?php echo implode(' ', $numerosSorteadosTresVezesCincoUltimos); ?></p>
        <br />
        <p>
            Grupo um (<?php echo count($grupoUm); ?>): <?php echo implode(' ', $grupoUm); ?>
            - sorteados <?php echo count($sorteadosGrupoUm); ?>
        </p>
        <p>Grupo dois (<?php echo count($grupoDois); ?>): <?php echo implode(' ', $grupoDois); ?>
            - sorteados <?php echo count($sorteadosGrupoDois); ?>
        </p>
        <p>Grupo três (<?php echo count($grupoTres); ?>): <?php echo implode(' ', $grupoTres); ?>
            - sorteados <?php echo count($sorteadosGrupoTres); ?>
        </p>
        <p>Total: <?php echo count($grupoUm) + count($grupoDois) + count($grupoTres); ?></p>
        <p>Grupo quatro (<?php echo count($grupoQuatro); ?>): <?php echo implode(' ', $grupoQuatro); ?>
            - sorteados <?php echo count($sorteadosGrupo4); ?>
        </p>
        
        <?php
        
        if (empty($saidaSorteadosProximo)) {
            ?>
            <hr /><p>Jogar:</p>
            <p><?php echo implode(' ', escolhe_itens_aleatorios($grupoUm, 7)); ?>
            <p><?php echo implode(' ', escolhe_itens_aleatorios($grupoDois, 6)); ?></p>
            <p><?php echo implode(' ', escolhe_itens_aleatorios($grupoTres, 7)); ?></p>
            <?php


        }
        
        ?>

    </div>
    <hr />
    <?php
        
    }


    $csv[] =
        "$sorteio, $proximo, ".count($grupoUm).", ".count($sorteadosGrupoUm).", ".count($grupoDois).", ".count($sorteadosGrupoDois).", ".count($grupoTres).", ".count($sorteadosGrupoTres).", ".count($grupoQuatro).", ".count($sorteadosGrupo4).", ".implode(', ', $saidaSorteadosProximo).", '|' ,".implode(', ', $todosOs60)
    ;
}

echo '<pre>';
echo implode(PHP_EOL, $csv);
echo '</pre>';

if ($_GET["gerar-csv"] === 'sim') {
    // save $csv contents to ../csv/$csvFilename  folder
    $csvFile = fopen("../csv/$csvFilename", "w");
    foreach ($csv as $line) {
        fputcsv($csvFile, explode(',', $line));
    }
    fclose($csvFile);
}
