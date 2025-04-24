<?php

namespace App\Services;

use App\Repositories\MegasenaRepository;
use App\Helpers\LegacyHelper;

class MegasenaService
{
    private $repository;

    public function __construct(MegasenaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function obterResultado()
    {
        return $this->repository->obterResultadoRecente();
    }

    public function obterNumerosMaisSorteados()
    {
        return $this->repository->obterNumerosMaisSorteados();
    }

    public function obterTop10(): array
    {
        $result = $this->repository->obterTop10();

        foreach ($result as $sorteio) {
            $return[] = $sorteio;
        }
        return $return;
    }

    public function obterUltimos20Sorteios(): array
    {
        $return = [];
        $result = $this->repository->obterUltimos20Sorteios();

        foreach ($result as $sorteio) {
            $return[] = $sorteio;
        }
        return $return;
    }

    public function lastTop10($sorteioInicial = 0, $sorteioFinal = 0)
    {
        $result = $this->repository->lastTop10($sorteioInicial, $sorteioFinal);
        $return = [];
        $i = 0;
        foreach ($result as $sorteio) {
            $return[] = $sorteio['num'];
            $i++;
            if ($i == 10) {
                break;
            }
        }
        return $return;
    }

    public function inserirVariosSorteios($data)
    {
        $rows = explode("\n", str_replace("\r", "", $data['values']));

        foreach ($rows as $row) {
            $fields = explode(';', $row);
            $data = array(
                'jogo' => $fields[0],
                'a' => $fields[1],
                'b' => $fields[2],
                'c' => $fields[3],
                'd' => $fields[4],
                'e' => $fields[5],
                'f' => $fields[6]
            );
            $this->repository->inserir($data);
        }
    }

    public function excluirSorteio($cdJogo)
    {
        return $this->repository->excluirSorteio($cdJogo);
    }

    public function zerar()
    {
        return $this->repository->zerar();
    }

    public function getUltimoSorteio()
    {
        return $this->repository->getUltimoSorteio();
    }

    public function gerarGraficos($ultimoSorteio)
    {

        $conn = $this->repository->getConnection();

        $strSQL = "TRUNCATE tbl_SenaGraficos";
        $conn->query($strSQL);

        for ($i = 11;$i <= $ultimoSorteio;$i++) {
            $arSorteados = LegacyHelper::fnSena($i);
            $j = $i - 10;
            echo "<p><b>$i ~ $j</b><br>\n";
            print_r($arSorteados);
            echo "<br>\n";
            $achados = 0;
            $strSQL = "
                SELECT COUNT(*) as total, num 
                FROM tbl_Sena
                WHERE jogo < $i AND jogo > $j
                GROUP BY num
                ";

            $stmt = $conn->query($strSQL);

            $result = $stmt->fetchAll();

            $numerosdiferentes = count($result);

            $nrMaisSorteio  = 0;
            $nrMeioSorteio  = 0;
            $nrMenosSorteio = 0;

            $total = [];

            // sorteados deste entre os 10 anteriroes
            foreach ($result as $array) {
                $n = $array["num"];
                if (array_search($n, $arSorteados)) {
                    echo "achou $n ".$array["total"]."<br>\n";
                    $total[$array["total"]]++;
                    $achados++;
                }
            } // while
            // sorteados no top 20/40/60
            $strSQL = "
                SELECT COUNT(*) as total, num 
                FROM tbl_Sena
                WHERE jogo < $i
                GROUP BY num
                ORDER BY total DESC
                ";
            $stmt = $conn->query($strSQL);
            $result = $stmt->fetchAll();
            $ordem = 0;
            foreach ($result as $array) {
                $ordem++;
                foreach ($arSorteados as $dezena) {
                    if ($dezena == $array["num"]) {
                        echo "$dezena - ".$array["num"]." - ".$ordem." - ".$array["total"]."<br>\n";
                        if ($ordem >=  1 && $ordem <= 20) {
                            $nrMaisSorteio++;
                        }
                        if ($ordem >= 21 && $ordem <= 40) {
                            $nrMeioSorteio++;
                        }
                        if ($ordem >= 41 && $ordem <= 60) {
                            $nrMenosSorteio++;
                        }
                    }
                }
            } //
            echo "achados: $achados de $numerosdiferentes <br> \n ";
            $strSQL = "
                DELETE FROM tbl_SenaGraficos
                WHERE cdSorteio = $i
                LIMIT 1
            ";
            $conn->query($strSQL);
            $strSQL = "
            INSERT INTO tbl_SenaGraficos
                (cdSorteio, nrDezSorteio, nrDezTotalSorteio, nrMaisSorteio, nrMeioSorteio, nrMenosSorteio)
            VALUES
                ($i, $achados, $numerosdiferentes, $nrMaisSorteio, $nrMeioSorteio, $nrMenosSorteio)
            ";
            $conn->query($strSQL);

        }
        print_r($total);
    }

    public function obterResumoGraficos()
    {
        $conn = $this->repository->getConnection();
        $strSQL = "
        SELECT
            AVG(nrMaisSorteio)     as mais,
            AVG(nrMeioSorteio)     as meio,
            AVG(nrMenosSorteio)    as menos,
            AVG(nrDezSorteio)      as dez,
            AVG(nrDezTotalSorteio) as totaldez
        FROM tbl_SenaGraficos
        ";
        $stmt = $conn->query($strSQL);
        $result = $stmt->fetchAll();
        return $result[0];
    }

    public function obterGraficosMais()
    {
        $conn = $this->repository->getConnection();
        $strSQL = "
            SELECT COUNT(*) as nr, `nrMaisSorteio`
            FROM `tbl_SenaGraficos`
            GROUP BY `nrMaisSorteio`
            ORDER BY nr DESC
        ";
        $result = $conn->query($strSQL);
        return $result->fetchAll();
    }

    public function obterGraficosMeio()
    {
        $conn = $this->repository->getConnection();
        $strSQL = "
            SELECT COUNT(*) as nr, `nrMeioSorteio`
            FROM `tbl_SenaGraficos`
            GROUP BY `nrMeioSorteio`
            ORDER BY nr DESC
        ";
        $result = $conn->query($strSQL);
        return $result->fetchAll();
    }

    public function obterGraficosMenos()
    {
        $conn = $this->repository->getConnection();
        $strSQL = "
            SELECT COUNT(*) as nr, `nrMenosSorteio`
            FROM `tbl_SenaGraficos`
            GROUP BY `nrMenosSorteio`
            ORDER BY nr DESC
        ";
        $result = $conn->query($strSQL);
        return $result->fetchAll();
    }

    public function obterGraficosUltimaRepeticao()
    {
        $conn = $this->repository->getConnection();
        $return = [];
        for ($i = 1;$i <= 60;$i++) {
            $ultimavez = -1;
            $rep = 0;
            $strSQL = "SELECT * FROM tbl_Sena WHERE num = $i ORDER BY jogo ";
            $result = $conn->query($strSQL);
            $result = $result->fetchAll();
            foreach ($result as $array) {
                if ($array["jogo"] == ($ultimavez + 1)) {
                    $rep++;
                }
                $ultimavez = $array["jogo"];
            }
            $return[$i] = ["num" => $array["jogo"], "repeticao" => $rep];
        }
        return $return;
    }

    public function obterGerar()
    {
        $conn = $this->repository->getConnection();
        $ultimoSorteio = $this->getUltimoSorteio();
        $dezUltimos = $ultimoSorteio - 10;
        for ($i = 1; $i <= 60; $i++) {
            $strSQL = "SELECT COUNT(*) AS total FROM tbl_Sena WHERE num = $i";
            $result = $conn->query($strSQL);
            $result = $result->fetch();
            $qtdd = $result['total'];
            $strSQL = "SELECT COUNT(*) as total FROM tbl_Sena WHERE num = $i AND jogo > $dezUltimos ";
            $result = $conn->query($strSQL);
            $result = $result->fetch();
            $qtdd_ultimas = $result['total'];
            $strSQL = "SELECT jogo FROM tbl_Sena WHERE num = $i ORDER BY jogo DESC";
            $result = $conn->query($strSQL);
            $result = $result->fetch();
            $ultima = $result['jogo'];
            $strSQL = "INSERT INTO tbl_SenaNum (cd, ultima, qtdd, qtdd_ultimas) VALUES ($i, $ultima, $qtdd, $qtdd_ultimas)";
            $conn->query($strSQL);
        }
    }

    public function obterGerarDois()
    {
        $conn = $this->repository->getConnection();
        $ultimoSorteio = $this->getUltimoSorteio();
        $dezUltimos = $ultimoSorteio - 10;

        for ($sorteio = $dezUltimos;$sorteio <= $ultimoSorteio;$sorteio++) {
            echo "\n<h2>$sorteio</h2>";
            $strSQL = "SELECT * FROM tbl_Sena WHERE jogo = $sorteio LIMIT 6 ";
            $result = $conn->query($strSQL);
            $result = $result->fetchAll();
            foreach ($result as $array) {
                $arSorteados[] = $array["num"];
            }
            $strSQL = " SELECT num, COUNT(*) as nrTotal FROM tbl_Sena WHERE jogo >= ".($sorteio - 10)." AND jogo < $sorteio GROUP BY num ORDER BY nrTotal ";
            $stmt = $conn->query($strSQL);

            echo "\n <br> Linhas: ".$stmt->rowCount()."<br> \n";
            unset($ar60);
            $result = $stmt->fetchAll();
            $nrDez = 0;
            foreach ($result as $array) {
                $ar60[] = $array["num"];
                if ($sorteio == $ultimoSorteio) {
                    echo "\n <br> ".$array["num"]." - ".$array["nrTotal"];
                } else {
                    if (in_array($array["num"], $arSorteados)) {
                        echo "\n <br> ".$array["num"]." - ".$array["nrTotal"];
                        $nrDez++;
                    }
                }
            }
            echo "<br>\nTotal: $nrDez<br>";
            sort($ar60);
            print_r($ar60);
            unset($arSorteados);
            unset($nrDez);
        }
    }

    public function obterNumeros()
    {

        $conn = $this->repository->getConnection();
        $strSQL = "SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC LIMIT 2";

        $numeros1a60 = range(1, 60);

        $res = $conn->query($strSQL)->fetchAll();
        $nrUltimo = $res[0]["jogo"];
        $nrPenultimo = $res[1]["jogo"];
        $nrCincoAtras = $nrUltimo - 5;
        $nrDezAtras = $nrUltimo - 10;

        $query = "SELECT * FROM tbl_SenaNum ORDER BY qtdd DESC, ultima DESC";
        $mais = $conn->query($query)->fetchAll();

        $maisLimpos = array();

        foreach ($mais as $array) {
            $maisLimpos[] = $array["cd"];
        }

        $escolhidos = array_chunk($maisLimpos, 7);
        $linhaA = $escolhidos[0];
        $linhaB = $escolhidos[1];
        $linhaC = $escolhidos[2];
        $linhaD = $escolhidos[3];

        ?>
        

<hr />

<p>Instruções:<br>
No total, vc deverá selecionar 24 números.<br>
Anote-os no bloco de notas, papel, word, qquer coisa. Vc usará no próximo passo.<br>
Selecione os números de acordo com as instruções individuais, para cada linha.<br>
Não precisa seguir a recomendação abaixo a risca.<br>
Verifique se, na sua escolha, há números repetidos. Se houver, substitua por outro.<br>
Se acabarem os números disponíveis e for necessário escolher mais números, prefira os números que mais saíram (primeira linha de números).<br>
</p>

<?php

$strSQL = "SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC LIMIT 1";
        $resSorteios = $conn->query($strSQL);
        $resSorteios = $resSorteios->fetch();
        // var_dump($resSorteios);
        // $arSorteio = $resSorteios[0];
        $nrUltimoConcurso = $resSorteios["jogo"];
        var_dump($resSorteios);
        echo '<h1>Último concurso cadastrado: '.$nrUltimoConcurso.'</h2>';
        $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$nrUltimoConcurso." ORDER BY num ";
        echo '<p>'.__LINE__.' : '.$strSQL.'</p>';
        $resSorteado = $conn->query($strSQL);

        while ($arSorteado = $resSorteado->fetch()) {
            $resultadosConcursos[$nrUltimoConcurso][] = $arSorteado['num'];
            $anterior = 0;
            echo PHP_EOL."<br /><br /> ".($arSorteado['num'])."<br />".PHP_EOL;
            $query = "SELECT jogo FROM tbl_Sena WHERE num = ".$arSorteado['num']." ORDER BY jogo DESC ";
            $result = $conn->query($query);
            $result = $result->fetchAll();
            foreach ($result as $row) {
                // var_dump($row);
                if ($anterior == $row['jogo']) {
                    echo($anterior + 1);

                    echo (" " . $row['jogo']).PHP_EOL;
                }

                $anterior = ($row['jogo'] - 1);
            }
        }
        ?>
<hr>
<?php
        var_dump($resultadosConcursos[$nrUltimoConcurso]);
        ?>
<h1>Sorteio: <?php echo $nrUltimoConcurso; ?></h1>
<p style="font-size: 11px">* saíram no sorteio anterior<p>
<p>Selecione os 6 primeiros números abaixo (números que mais saem): <br>
+ : <?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY qtdd DESC, ultima LIMIT 12";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            echo $array["cd"];
            // convert $array["cd"] to string
            if (in_array(strval($array["cd"]), $resultadosConcursos[$nrUltimoConcurso])) {
                echo "*";
            }
            echo " &nbsp; ";
        }
        ?></p>

<p>Números que faz tempo que não saem:<br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY ultima, qtdd DESC LIMIT 12";
        $result = $conn->query($strSQL);

        while ($array = $result->fetch()) {
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo $array["cd"];
            if (in_array(strval($array["cd"]), $resultadosConcursos[$nrUltimoConcurso])) {
                echo "*";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            echo " &nbsp; ";
        }
        ?></p>
<p>Números que menos saem: <br>
- <?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY qtdd, ultima DESC LIMIT 12";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"]);
            if (in_array(strval($array["cd"]), $resultadosConcursos[$nrUltimoConcurso])) {
                echo "*";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            echo " &nbsp; ";
        }
        ?></p>
<h1>Sorteio: <?php echo $nrUltimoConcurso; ?></h1>
<p>Números que mais saíram nos últimos 10 sorteios: <br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas > 0 ORDER BY qtdd_ultimas DESC, ultima ";
        $result = $conn->query($strSQL);
        $numerosMaisSairamUltimosDez = array();
        while ($array = $result->fetch()) {
            // var_dump($array);
            $numerosMaisSairamUltimosDez[] = $array["cd"];

            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"]."/".$array["qtdd_ultimas"].")";

            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }

            echo " &nbsp; ";

        }
        ?></p>
<!-- NÃO PRECISA SER EXIBIDO, SOMENTE CALCULADO

<h2>Números que saíram 2 ou mais vezes nos últimos 10 sorteios</h2>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas > 0 ORDER BY qtdd_ultimas DESC, ultima ";
        $result = $conn->query($strSQL);
        $somenteNumerosDuasVezesUltimosDez = array();
        while ($array = $result->fetch()) {
            if ($array["qtdd_ultimas"] <= 1) {
                continue;
            }
            $somenteNumerosDuasVezesUltimosDez[] = $array["cd"];
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            } else {
                $numerosMaisSairamUltimosDez[] = $array["cd"];
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"]."/".$array["qtdd_ultimas"].")";
            if (LegacyHelper::snUltimosJogos($array["cd"])) {
                echo "*";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " &nbsp; ";

        }
        ?></p>
<p><?php echo implode(' ', $somenteNumerosDuasVezesUltimosDez); ?></p>
-->
<?php



        // números que saíram nos últimos 10 sorteios
        $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo > $nrDezAtras and jogo <= $nrUltimo GROUP BY num; ";
        $result = $conn->query($strSQL);
        $numerosSorteadosUmaVezDezUltimos = [];
        $numerosSorteadosDuasVezesDezUltimos = [];
        $numerosSorteadosQuatroVezesDezUltimos = [];
        while ($array = $result->fetch()) {
            $numerosSorteadosUmaVezDezUltimos[] = $array["cd"];
            if ($array["qtdd_ultimas"] >= 2) {
                $numerosSorteadosDuasVezesDezUltimos[] = $array["cd"];
            }
            if ($array["qtdd_ultimas"] >= 4) {
                $numerosSorteadosQuatroVezesDezUltimos[] = $array["cd"];
            }
        }

        // $numerosSorteadosUmaVezCincoUltimos
        $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo > $nrCincoAtras and jogo <= $nrUltimo GROUP BY num; ";
        echo '<p>'.__LINE__.' $numerosSorteadosUmaVezCincoUltimos : '.$strSQL.'</p>';
        $result = $conn->query($strSQL);
        $numerosSorteadosUmaVezCincoUltimos = [];
        $numerosSorteadosTresVezesCincoUltimos = [];
        while ($array = $result->fetch()) {
            $numerosSorteadosUmaVezCincoUltimos[] = $array["cd"];
            if ($array["qtdd_ultimas"] >= 3) {
                $numerosSorteadosTresVezesCincoUltimos[] = $array["cd"];
            }
        }

        // $numerosSorteadosUmaVezCincoPenultimos
        $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo <= $nrCincoAtras AND jogo > $nrDezAtras GROUP BY num; ";
        echo '<p>'.__LINE__.' $numerosSorteadosUmaVezCincoPenultimos : '.$strSQL.'</p>';
        $result = $conn->query($strSQL);
        $numerosSorteadosUmaVezCincoPenultimos = [];
        while ($array = $result->fetch()) {
            $numerosSorteadosUmaVezCincoPenultimos[] = $array["cd"];
        }
        ?>
<p>
Números que saíram nos últimos 10 sorteios (<?php echo count($numerosSorteadosUmaVezDezUltimos); ?>): <?php echo implode(' ', $numerosSorteadosUmaVezDezUltimos); ?><br>
Números que saíram 2 ou mais vezes nos últimos 10 sorteios (<?php echo count($numerosSorteadosDuasVezesDezUltimos); ?>): <?php echo implode(' ', $numerosSorteadosDuasVezesDezUltimos); ?>
</p>

<h2>Grupo 1: números que saíram nos últimos 5 sorteios (<?php echo " > " . $nrCincoAtras; ?>)
 cruzados com números que saíram 2 ou mais vezes nos últimos 10 sorteios. </h2>
<?php
        $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo > $nrCincoAtras and jogo <= $nrUltimo GROUP BY num; ";
        echo '<p>'.__LINE__.' : '.$strSQL.'</p>';
        $result = $conn->query($strSQL);
        $somenteNumerosCincoUltimos = array();
        $somenteNumerosCincoUltimosMaisQueUmaVez = array();
        while ($array = $result->fetch()) {
            $somenteNumerosCincoUltimos[] = $array["cd"];
            if ($array["qtdd_ultimas"] > 1) {
                continue;
            }
            $somenteNumerosCincoUltimosMaisQueUmaVez[] = $array["cd"];
        }
        $grupoUm = array_intersect($somenteNumerosCincoUltimos, $somenteNumerosDuasVezesUltimosDez);
        ?></p>

<p>Grupo um: <?php echo implode(' ', $grupoUm); ?></p>

<hr />

<h2>Grupo 2: números que tenham saído uma vez  entre os 10 últimos e
	que tenham saído uma vez entre os 5 últimos.
</h2>
<?php
        $strSQL = "SELECT num AS cd, COUNT(*) as qtdd_ultimas FROM `tbl_Sena` WHERE jogo <= $nrCincoAtras AND jogo > $nrDezAtras GROUP BY num; ";

        $result = $conn->query($strSQL);
        $somenteNumeros = array();
        while ($array = $result->fetch()) {
            $somenteNumeros[] = $array["cd"];
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                // echo "<strong>";
            } else {
                $numerosMaisSairamUltimosDez[] = $array["cd"];
            }
            var_dump($array);
            continue;
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"]."/".$array["qtdd_ultimas"].")";
            if (LegacyHelper::snUltimosJogos($array["cd"])) {
                echo "*";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " &nbsp; ";

        }
        $grupoDois = array_diff($somenteNumeros, $somenteNumerosCincoUltimos);
        ?></p>
<p>Grupo dois: <?php echo implode(' ', $grupoDois); ?></p>
<hr />

<?php
        $grupoUm = array_diff($grupoUm, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos);

        $grupoDois = array_diff(array_intersect($numerosSorteadosUmaVezDezUltimos, $numerosSorteadosUmaVezCincoUltimos), $grupoUm);
        $grupoDois = array_diff($grupoDois, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos);

        $grupoTres = array_diff(array_intersect($numerosSorteadosUmaVezDezUltimos, $numerosSorteadosUmaVezCincoPenultimos), $grupoUm, $grupoDois);
        $grupoTres = array_diff($grupoTres, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos);

        $grupoQuatro = array_diff($numeros1a60, $grupoUm, $grupoDois, $grupoTres);
        $grupoQuatro = array_diff($grupoQuatro, $numerosSorteadosQuatroVezesDezUltimos, $numerosSorteadosQuatroVezesDezUltimos);
        ?>

<div style="border: 1px solid pink; padding: 5px; width: 100%;">
	<h1>Quatro grupos para <?php echo $nrUltimo + 1; ?> - (Atualizado em 2024-07-09)</h2>
	<p>Numeros Sorteados Quatro Vezes Dez Ultimos (<?php echo count($numerosSorteadosQuatroVezesDezUltimos); ?>): <?php echo implode(' ', $numerosSorteadosQuatroVezesDezUltimos); ?></p>
	<p>Numeros sorteados três vezes 5 últimos (<?php echo count($numerosSorteadosTresVezesCincoUltimos); ?>): <?php echo implode(' ', $numerosSorteadosTresVezesCincoUltimos); ?></p>
	<br />
	<p>Grupo um (<?php echo count($grupoUm); ?>): <?php echo implode(' ', $grupoUm); ?></p>
	<p>Grupo dois (<?php echo count($grupoDois); ?>): <?php echo implode(' ', $grupoDois); ?></p>
	<p>Grupo três (<?php echo count($grupoTres); ?>): <?php echo implode(' ', $grupoTres); ?></p>
	<p>Total: <?php echo count($grupoUm) + count($grupoDois) + count($grupoTres); ?></p>
	<p>Grupo quatro (<?php echo count($grupoQuatro); ?>): <?php echo implode(' ', $grupoQuatro); ?></p>
	<hr />
	<p>Legenda</p>
	<p>Grupo 1: números que saíram nos últimos 5 sorteios ( > 2741) cruzados com números que saíram 2 ou mais vezes nos últimos 10 sorteios.</p>
	<p>Grupo 2: números que tenham saído uma vez  entre os 10  últimos e que tenham saído uma vez entre os 5 últimos
	<p>Grupo 3: números que tenham saído pelo menos uma vez entre os 10 últimos mas não tenham saído nos 5 últimos
	<p>Grupo 4: números que não saíram nos últimos 10 sorteios</p>
</div>
<p>&nbsp;</p>
<pre>
<?php

        $numerosMaisSairamUltimosDezSemOUltimo = array_diff($numerosMaisSairamUltimosDez, $resultadosConcursos[$nrUltimoConcurso]);
        $numerosMaisSairamUltimosDez = array_chunk($numerosMaisSairamUltimosDezSemOUltimo, 8);
        // array_walk ($numerosMaisSairamUltimosDez[0], printNumero);
        // array_walk ($numerosMaisSairamUltimosDez[1], printNumero);
        // array_walk ($numerosMaisSairamUltimosDez[2], printNumero);
        // array_walk ($numerosMaisSairamUltimosDez[3], printNumero);
        echo implode(' ', $numerosMaisSairamUltimosDez[0]).PHP_EOL;
        echo implode(' ', $numerosMaisSairamUltimosDez[1]).PHP_EOL;
        echo implode(' ', $numerosMaisSairamUltimosDez[2]).PHP_EOL;
        echo implode(' ', $numerosMaisSairamUltimosDez[3]).PHP_EOL;

        ?>
</pre>
<hr />
<p>Números que saíram nos últimos 10 sorteios com maior atraso: <br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas > 0 ORDER BY ultima ";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"].")";
            if (LegacyHelper::snUltimosJogos($array["cd"])) {
                echo "*";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " &nbsp; ";
        }
        ?></p>

<p>mesmos números acima que saíram nos últimos 10 sorteios com maior atraso: <br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas = 1 ORDER BY ultima ";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"]); //."(".$array["ultima"].")";
            //if(LegacyHelper::snUltimosJogos($array["cd"])){ echo "*";}
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " ";
        }

        echo "<br>\n<br>\n";

        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas = 1 ORDER BY ultima ";
        $result = $conn->query($strSQL);
        $i = 0;
        while ($array = $result->fetch()) {
            if ($i == 3 or $i == 6 or $i == 11 or $i == 13 or $i == 15 or $i == 17 or $i == 21 or $i == 23 or $i == 25 or $i == 27) {
                echo "<br\n>";
            }
            if ($i == 9 or $i == 19 or $i == 29) {
                echo "<br>\n<br>\n";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"]); //."(".$array["ultima"].")";
            //if(LegacyHelper::snUltimosJogos($array["cd"])){ echo "*";}
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " ";
            $i++;
        }


        echo "<br>\n<br>\n";
        echo '<div style="border: 2px solid #F00">';
        echo "<p>Não esqueça de remover o espaço final de cada linha</p>";
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas = 1 ORDER BY ultima ";
        $result = $conn->query($strSQL);
        $i = 0;
        while ($array = $result->fetch()) {
            if ($i == 8 or $i == 16) {
                echo "<br>\n";
            }
            if ($i == 24) {
                echo "</div><br>\n<br>\n";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            if ($array["ultima"] == $nrUltimo) {
                echo "<font color=red>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"]); //."(".$array["ultima"].")";
            //if(LegacyHelper::snUltimosJogos($array["cd"])){ echo "*";}
            if ($array["ultima"] == $nrUltimo) {
                echo "</font>";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " ";
            $i++;
        }
        echo "";
        echo "<br clear=all>\n";


        ?></p>
<p>Números não que saíram nos últimos 10 : <br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum WHERE qtdd_ultimas = 0 ORDER BY ultima ";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"].")";
            if (LegacyHelper::snUltimosJogos($array["cd"])) {
                echo "*";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " &nbsp; ";
        }
        ?></p>
<p>Se vc escolheu exatamente os números indicados acima, ainda faltam 6 números.<br>
Na tabela abaixo, coluna <strong>próxima vez</strong> , selecione em ordem:<br>
1) os números em vermelho e negrito<br>
2) os números em negrito.<br>
Obs.: É possível que não haja nenhum número em vermelho e/ou negrito.<br>
Se houver exatamente 6 números, ÓTIMO.<br>
Se houver menos que 6 números, escolha algum número das listas acima.<br>
Se houver algum número repetido, não escolha. Passe para outro.<br>
Se houver mais que 6 números, paciência. Algum vai sobrar.</p>

<table>
<tr><th>menos apareceram</th><th>mais apareceram</th><th>faz tempo</th><th>próxima vez</th>
<tr>
<td><ol>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY qtdd, ultima DESC";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            echo "<li>";
            echo $array["cd"]." - ";
            echo $array["ultima"]." - ";
            echo $array["qtdd"]."<br> \n ";
            echo "</li>";
        }
        ?></ol>
</td>
<td nowrap>
<ol>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY qtdd DESC, ultima";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            echo "<li>";
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "<strong>";
            }
            echo LegacyHelper::fnDoisDigitos($array["cd"])."(".$array["ultima"].")(".$array["qtdd"].")";
            if (LegacyHelper::snUltimosJogos($array["cd"])) {
                echo "*";
            }
            if (LegacyHelper::snUltimoJogo($array["cd"])) {
                echo "</strong>";
            }
            echo " &nbsp; ";

            echo "</li>";
        }
        ?>
</ol>
<br>AQUI<br>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY qtdd DESC, ultima";
        $result = $conn->query($strSQL);
        $l = 0;
        $limite = 6;
        $grupos = 0;
        while ($array = $result->fetch()) {
            $l++;
            echo LegacyHelper::fnDoisDigitos($array["cd"]);

            if ($l >= $limite) {
                echo "<br> \n ";
                $grupos++;
                $l = 0;
                if ($grupos >= 3) {
                    $limite = 6;
                }
            } else {
                echo " ";
            }

        }
        ?>
</td>

<td><ol>
<?php
        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY ultima, qtdd DESC";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            echo "<li>";
            echo $array["cd"]." - ";
            echo $array["ultima"]." - ";
            echo $array["qtdd"]."<br> \n ";
            echo "</li>";
        }
        ?></ol>
</td>


<td><ol>
<?php
        // busca numero do ultimo sorteio

        $strSQL = "SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC LIMIT 1";
        $resSorteios = $conn->query($strSQL);
        $arSorteio = $resSorteios->fetch();
        $ultimojogo = $arSorteio["jogo"];
        $proximojogo = $ultimojogo + 1;
        // echo "Último: $ultimojogo - Próximo: $proximojogo <Br> \n";


        $strSQL = "SELECT * FROM tbl_SenaNum ORDER BY cd ";
        $result = $conn->query($strSQL);
        while ($array = $result->fetch()) {
            // ver ultima vez q o numero saiu
            $strSQL = "SELECT * FROM tbl_SenaNum WHERE cd = ".$array["cd"]." ";
            $resultAux = $conn->query($strSQL);
            $ultimavez = $resultAux->fetch()["ultima"];

            echo "<li>";
            echo $array["cd"]." - ";
            $media = $ultimavez / $array["qtdd"];
            echo $media." - ";
            echo $ultimavez." - ";
            $proximavez = ceil($ultimavez + $media);
            if ($proximavez  == $proximojogo) {
                echo '<span style="font-size: 12pt; font-weight: bold; color: #ff0000">'. $proximavez .'</span> - ';
            } else {
                if ($proximavez  == $ultimojogo or $proximavez  == ($proximojogo + 1)) {
                    echo '<span style="font-size: 11pt; font-weight: bold">'. $proximavez .'</span> - ';
                } else {
                    echo $proximavez." - ";
                }
            }


            echo "</li>";
        }
        ?></ol>
</td>

</tr>
</table>

        
        <?php
                return [
                    'linhaA' => $linhaA,
                    'linhaB' => $linhaB,
                    'linhaC' => $linhaC,
                    'linhaD' => $linhaD
                ];

    }

    public function processarCombinar322($maisoutrosmenos)
    {

        $conn = $this->repository->getConnection();

        $arMaisoutrosmenos = explode("\n", $maisoutrosmenos);

        $arMais   = explode(" ", trim($arMaisoutrosmenos[0]));
        $arOutros = explode(" ", trim($arMaisoutrosmenos[1]));
        $arMenos  = explode(" ", trim($arMaisoutrosmenos[2]));

        sort($arMais);
        sort($arOutros);
        sort($arMenos);

        foreach ($arMais as $nrDezena0) {
            $arDezena0 = array_diff($arMais, array($nrDezena0));
            foreach ($arDezena0 as $nrDezena1) {
                $arDezena2 = array_diff($arDezena0, array($nrDezena1));
                foreach ($arDezena2 as $nrDezena2) {
                    $arDezena3 = $arOutros;
                    foreach ($arDezena3 as $nrDezena3) {
                        $arDezena4 = array_diff($arDezena3, array($nrDezena3));
                        foreach ($arDezena4 as $nrDezena4) {
                            $arDezena5 = $arMenos;
                            foreach ($arDezena5 as $nrDezena5) {
                                $arDezena6 = array_diff($arDezena5, array($nrDezena5));
                                foreach ($arDezena6 as $nrDezena6) {
                                    $jogo = array($nrDezena0 ,$nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
                                    sort($jogo);
                                    $a = $jogo[0];
                                    $b = $jogo[1];
                                    $c = $jogo[2];
                                    $d = $jogo[3];
                                    $e = $jogo[4];
                                    $f = $jogo[5];
                                    $g = $jogo[6];

                                    $strSQL = "SELECT cd FROM tbl_SenaJogos7 WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f AND g = $g LIMIT 1";
                                    $resultRepetido = $conn->query($strSQL);

                                    if ($resultRepetido->rowCount() == 0) {
                                        $strSQL = "
                                            INSERT INTO tbl_SenaJogos7
                                            ( a , b , c , d , e , f, g)
                                            VALUES
                                            ($a ,$b, $c, $d, $e, $f, $g)
                                        ";
                                        $conn->query($strSQL);
                                    }
                                    set_time_limit(0);
                                }
                            }

                        }
                    }

                }
            }
        }

    }

    public function processarCombinar222($maisoutrosmenos)
    {

        $conn = $this->repository->getConnection();

        $arMaisoutrosmenos = explode("\n", $maisoutrosmenos);

        $arMais   = explode(" ", trim($arMaisoutrosmenos[0]));
        $arOutros = explode(" ", trim($arMaisoutrosmenos[1]));
        $arMenos  = explode(" ", trim($arMaisoutrosmenos[2]));

        sort($arMais);
        sort($arOutros);
        sort($arMenos);

        foreach ($arMais as $nrDezena1) {
            $arDezena2 = array_diff($arMais, array($nrDezena1));
            foreach ($arDezena2 as $nrDezena2) {
                $arDezena3 = $arOutros;
                foreach ($arDezena3 as $nrDezena3) {
                    $arDezena4 = array_diff($arDezena3, array($nrDezena3));
                    foreach ($arDezena4 as $nrDezena4) {
                        $arDezena5 = $arMenos;
                        foreach ($arDezena5 as $nrDezena5) {
                            $arDezena6 = array_diff($arDezena5, array($nrDezena5));
                            foreach ($arDezena6 as $nrDezena6) {
                                $jogo = array($nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
                                sort($jogo);
                                $a = $jogo[0];
                                $b = $jogo[1];
                                $c = $jogo[2];
                                $d = $jogo[3];
                                $e = $jogo[4];
                                $f = $jogo[5];

                                $nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
                                $nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
                                $nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
                                $nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
                                $nrMedia     =  30;
                                $duplicados = count($jogo) !== count(array_unique($jogo));
                                if (!$duplicados) {
                                    $strSQL = "SELECT cd FROM tbl_SenaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
                                    $resultRepetido = $conn->query($strSQL);
                                    if ($resultRepetido->rowCount() == 0) {
                                        $strSQL = "
                                            INSERT INTO tbl_SenaJogos
                                            ( a , b , c , d , e , f)
                                            VALUES
                                            ($a ,$b, $c, $d, $e, $f)
                                        ";
                                        $conn->query($strSQL);
                                    }
                                }
                                set_time_limit(0);

                            }
                        }

                    }
                }
            }
        }
    }


    public function processarCombinar33($maisoutrosmenos)
    {

        $conn = $this->repository->getConnection();

        $arMaisoutrosmenos = explode("\n", $maisoutrosmenos);

        $arGrupoA = explode(" ", trim($arMaisoutrosmenos[0]));
        $arGrupoB = explode(" ", trim($arMaisoutrosmenos[1]));

        sort($arGrupoA);
        sort($arGrupoB);

        foreach ($arGrupoA as $nrDezena1) {
            $arDezena2 = array_diff($arGrupoA, array($nrDezena1));
            foreach ($arDezena2 as $nrDezena2) {
                $arDezena3 = array_diff($arGrupoA, array($nrDezena2));
                foreach ($arDezena3 as $nrDezena3) {
                    $arDezena4 = $arGrupoB;
                    foreach ($arDezena4 as $nrDezena4) {
                        $arDezena5 = array_diff($arGrupoB, array($nrDezena4));
                        foreach ($arDezena5 as $nrDezena5) {
                            $arDezena6 = array_diff($arDezena5, array($nrDezena5));
                            foreach ($arDezena6 as $nrDezena6) {
                                $jogo = array($nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
                                sort($jogo);
                                $duplicados = count($jogo) !== count(array_unique($jogo));
                                if ($duplicados) {
                                    continue;
                                }

                                $a = $jogo[0];
                                $b = $jogo[1];
                                $c = $jogo[2];
                                $d = $jogo[3];
                                $e = $jogo[4];
                                $f = $jogo[5];

                                $total = $a + $b + $c + $d + $e + $f;
                                if ($total < 110 || $total > 220) {
                                    continue;
                                }

                                // $nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
                                // $nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
                                // $nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
                                // $nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
                                // $nrMedia     =  30;

                                if (!$duplicados) {
                                    $strSQL = "SELECT cd FROM tbl_SenaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
                                    $resultRepetido = $conn->query($strSQL);
                                    if ($resultRepetido->rowCount() == 0) {
                                        $strSQL = "
                                            INSERT INTO tbl_SenaJogos
                                            ( a , b , c , d , e , f)
                                            VALUES
                                            ($a ,$b, $c, $d, $e, $f)
                                        ";
                                        $conn->query($strSQL);
                                    }
                                }
                                set_time_limit(0);

                            }
                        }

                    }
                }
            }
        }
    }

    public function processarCombinar111111($maisoutrosmenos)
    {

        $conn = $this->repository->getConnection();

        $arMaisoutrosmenos = explode("\n", $maisoutrosmenos);

        $arLinha1 = explode(" ", trim($arMaisoutrosmenos[0]));
        $arLinha2 = explode(" ", trim($arMaisoutrosmenos[1]));
        $arLinha3 = explode(" ", trim($arMaisoutrosmenos[2]));
        $arLinha4 = explode(" ", trim($arMaisoutrosmenos[3]));
        $arLinha5 = explode(" ", trim($arMaisoutrosmenos[4]));
        $arLinha6 = explode(" ", trim($arMaisoutrosmenos[5]));

        sort($arLinha1);
        sort($arLinha2);
        sort($arLinha3);
        sort($arLinha4);
        sort($arLinha5);
        sort($arLinha6);

        foreach ($arLinha1 as $nrDezena1) {
            foreach ($arLinha2 as $nrDezena2) {
                if ($nrDezena1 >= $nrDezena2) {
                    continue;
                }
                foreach ($arLinha3 as $nrDezena3) {
                    if ($nrDezena2 >= $nrDezena3) {
                        continue;
                    }
                    foreach ($arLinha4 as $nrDezena4) {
                        if ($nrDezena3 >= $nrDezena4) {
                            continue;
                        }
                        foreach ($arLinha5 as $nrDezena5) {
                            if ($nrDezena4 >= $nrDezena5) {
                                continue;
                            }
                            foreach ($arLinha6 as $nrDezena6) {
                                if ($nrDezena5 >= $nrDezena6) {
                                    continue;
                                }
                                echo "$nrDezena1 $nrDezena2 $nrDezena3 $nrDezena4 $nrDezena5 $nrDezena6 <br> \n";
                                $jogo = array($nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
                                sort($jogo);
                                $a = $jogo[0];
                                $b = $jogo[1];
                                $c = $jogo[2];
                                $d = $jogo[3];
                                $e = $jogo[4];
                                $f = $jogo[5];
                                $nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
                                $nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
                                $nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
                                $nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
                                $nrMedia     =  30 ;//array_sum($jogo) / 6;
                                if ((1 == 1) or
                                        ($nrColunas == 6 && $nrLinhas > 3 && $nrLinha1 < 3 && $nrSequencia <= 1 && $nrMedia > 0 && $nrMedia < 60) ||
                                        ($nrColunas >= 5 && $nrLinhas > 3 && $nrLinha1 < 3 && $nrSequencia == 0 && $nrMedia > 0 && $nrMedia < 60)
                                ) {
                                    $strSQL = "SELECT cd FROM tbl_SenaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
                                    $resultRepetido = $conn->query($strSQL);
                                    if ($resultRepetido->rowCount() == 0) {
                                        $strSQL = "
                                                    INSERT INTO tbl_SenaJogos
                                                    ( a , b , c , d , e , f)
                                                    VALUES
                                                    ($a ,$b, $c, $d, $e, $f)
                                                ";
                                        $conn->query($strSQL);
                                    }
                                }
                                set_time_limit(0);

                            }
                        }
                    }
                }
            }
        }
    }

    public function processarCombinar1221($maisoutrosmenos)
    {

        $conn = $this->repository->getConnection();

        $arMaisoutrosmenos = explode("\n", $maisoutrosmenos);
        print_r($arMaisoutrosmenos);

        $grupoA = explode(" ", $arMaisoutrosmenos[0]);
        $grupoB = explode(" ", $arMaisoutrosmenos[1]);
        $grupoC = explode(" ", $arMaisoutrosmenos[2]);
        $grupoD = explode(" ", $arMaisoutrosmenos[3]);

        sort($grupoA);
        sort($grupoB);
        sort($grupoC);
        sort($grupoD);

        // primeiro validar
        print_r($grupoA);
        print_r($grupoB);
        print_r($grupoC);
        print_r($grupoD);
        // depois combinar

        foreach ($grupoA as $nrDezena1) {
            $arDezena2 = $grupoB;
            foreach ($arDezena2 as $nrDezena2) {
                //
                $arDezena3 = array_diff($arDezena2, array($nrDezena2));
                foreach ($arDezena3 as $nrDezena3) {
                    $arDezena4 = $grupoC;
                    foreach ($arDezena4 as $nrDezena4) {
                        $arDezena5 = array_diff($arDezena4, array($nrDezena4));
                        foreach ($arDezena5 as $nrDezena5) {
                            $arDezena6 = $grupoD;
                            foreach ($arDezena6 as $nrDezena6) {
                                $jogo = array($nrDezena1 ,$nrDezena2, $nrDezena3, $nrDezena4, $nrDezena5, $nrDezena6);
                                sort($jogo);
                                $a = $jogo[0];
                                $b = $jogo[1];
                                $c = $jogo[2];
                                $d = $jogo[3];
                                $e = $jogo[4];
                                $f = $jogo[5];

                                $nrColunas   =           fnConfereColunas($a, $b, $c, $d, $e, $f);
                                $nrLinhas    =            fnConfereLinhas($a, $b, $c, $d, $e, $f);
                                $nrLinha1    =        fnConfereMesmaLinha($a, $b, $c, $d, $e, $f);
                                $nrSequencia =  fnConfereSequenciaSimples($a, $b, $c, $d, $e, $f);
                                $nrMedia     =  array_sum($jogo) / 6;
                                if (
                                    ($nrColunas == 6 && $nrLinhas > 3 && $nrLinha1 < 3 && $nrSequencia <= 1 && $nrMedia > 20 && $nrMedia < 40) ||
                                    ($nrColunas >= 5 && $nrLinhas > 3 && $nrLinha1 < 3 && $nrSequencia == 0 && $nrMedia > 20 && $nrMedia < 40)
                                ) {
                                    $strSQL = "SELECT cd FROM tbl_SenaJogos WHERE a = $a AND b = $b AND c = $c AND d = $d AND e = $e AND f = $f LIMIT 1";
                                    $resultRepetido = $conn->query($strSQL);
                                    if ($resultRepetido->rowCount() == 0) {
                                        $strSQL = "
                                                INSERT INTO tbl_SenaJogos
                                                ( a , b , c , d , e , f)
                                                VALUES
                                                ($a ,$b, $c, $d, $e, $f)
                                            ";
                                        $conn->query($strSQL);
                                    }
                                }
                                set_time_limit(0);
                            }
                        }
                    }
                }
            }
        }
    }

    public function processarJogosLimitar($qtdd)
    {

        echo '<h2>Limitar jogos: '.$qtdd.'</h2>';

        $conn = $this->repository->getConnection();

        $nrExcluidos = 0;

        $numerosPrimos = array( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

        // @TODO count para ver o total
        $sql = "SELECT COUNT(*) as total FROM tbl_SenaJogos";
        $stmt = $conn->query($sql);
        $arTotal = $stmt->fetch();
        $total = $arTotal["total"];
        echo 'Total de jogos: '.$total.'<br />';

        $frequencia = floor($total / (int)$qtdd);
        echo 'Frequencia: '.$frequencia.'<br />';
        $primeiro = floor($frequencia / 2);
        $i = 0;
        $linha = 0;
        $strSQL = "SELECT * FROM tbl_SenaJogos ORDER BY a, b, c, d, e, f ";
        $stmt = $conn->query($strSQL);
        while ($arJogo = $stmt->fetch()) {
            $i++;
            if ($i == $frequencia) {
                echo LegacyHelper::fnDoisDigitos($arJogo["a"])." ".LegacyHelper::fnDoisDigitos($arJogo["b"])." ".LegacyHelper::fnDoisDigitos($arJogo["c"])." ".LegacyHelper::fnDoisDigitos($arJogo["d"])." ".LegacyHelper::fnDoisDigitos($arJogo["e"])." ".LegacyHelper::fnDoisDigitos($arJogo["f"])." \n";
                $i = 0;
                $linha++;
                unset($primeiro);
                // if ($linha==2){echo "\n";$linha = 0;}
                echo '<br />';
            }
        }
    }

    public function exibirPepe()
    {
        $conexao = $this->repository->getConnection();
        include_once __DIR__ . '/../Views/pepe.php';
    }

}
