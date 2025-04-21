<?php

namespace App\Controllers;

use App\Services\MegasenaService;
use App\Database\DatabaseConnection;
use App\Repositories\MegasenaRepository;

class MegasenaController
{
    public function exibirInicio()
    {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);
        $numerosPrimos = array ( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["frmFuncao"] == "IncluirVariosSorteio") {
            $service->inserirVariosSorteios($_REQUEST);
        }
    
        if (@isset($_GET["excluir"]) && @is_numeric($_GET["excluir"]))
        {
            $cdJogo = $_GET["excluir"];
            echo "<p>Excluindo sorteio $cdJogo .</p>";
            $result = $service->excluirSorteio($cdJogo);
            if ($result) {
                echo "<p>Jogo $cdJogo eliminado.</p>";
            }
        }

        $resultado = $service->obterResultado();

        $top10 = $service->obterTop10();

        $ultimos20Sorteios = $service->obterUltimos20Sorteios();

        $recentTop10 = $service->lastTop10($ultimos20Sorteios[0]['jogo'] - 10, $ultimos20Sorteios[0]['jogo']);

        include_once __DIR__ . '/../Views/inicio.php';
    }

    public function exibirZerar()
    {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        $results = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["frmFuncao"] == "Zerar") {
            $results = $service->zerar();
        }

        include_once __DIR__ . '/../Views/zerar.php';
    }

    public function exibirGraficos()
    {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);
        $ultimoSorteio = $service->getUltimoSorteio();
        $resumo = $service->obterResumoGraficos();
        $mais = $service->obterGraficosMais();
        $meio = $service->obterGraficosMeio();
        $menos = $service->obterGraficosMenos();
        $ultimaRepeticao = $service->obterGraficosUltimaRepeticao();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $service->gerarGraficos($ultimoSorteio);
        }
    
        include_once __DIR__ . '/../Views/graficos.php';
    }

    public function exibirGerar()
    {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);
        $ultimoSorteio = $service->getUltimoSorteio();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $service->obterGerar($ultimoSorteio);
        }

        include_once __DIR__ . '/../Views/gerar.php';
    }

    public function exibirGerarDois()
    {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);
        $ultimoSorteio = $service->getUltimoSorteio();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $service->obterGerarDois();
        }

        include_once __DIR__ . '/../Views/gerar_2.php';
    }

    public function exibirNumeros() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        $numeros = $service->obterNumeros();

        include_once __DIR__ . '/../Views/numeros.php';
    }

    public function exibirCombinar322() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 3x2x2</h2>";
            $response = $service->processarCombinar322($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/combinar322.php';
    }

    public function exibirCombinar222() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 2x2x2</h2>";
            $response = $service->processarCombinar222($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/combinar222.php';
    }

    public function exibirCombinar33() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 3x3</h2>";
            $response = $service->processarCombinar33($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/combinar33.php';
    }

    public function exibirCombinar111111() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar_1x1x1x1x1x1") {
            echo "<h2>Combinando 1x1x1x1x1x1</h2>";
            $response = $service->processarCombinar111111($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/combinar111111.php';
    }

    public function exibirCombinar1221() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar1221") {
            echo "<h2>Combinando 1x1x1x1x1x1</h2>";
            $response = $service->processarCombinar1221($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/combinar1221.php';
    }

    public function exibirJogosLimitar() {
        $databaseConnection = new DatabaseConnection('127.0.0.1', 'hurpia_loteria', 'hurpia_loteria', 'adv69581');
        $megasenaRepository = new MegasenaRepository($databaseConnection);
        $service = new MegasenaService($megasenaRepository);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $response = $service->processarJogosLimitar($_POST["qtdd"]);
        }

        include_once __DIR__ . '/../Views/jogoslimitar.php';
    }
}