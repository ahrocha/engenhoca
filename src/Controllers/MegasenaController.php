<?php

namespace App\Controllers;

use App\Services\MegasenaService;
use App\Database\DatabaseConnection;
use App\Repositories\MegasenaRepository;
use App\Services\SecurityService;

class MegasenaController
{
    private MegasenaService $service;
    private SecurityService $securityService;

    public function __construct(
        MegasenaService $service,
        SecurityService $securityService
    ) {
        $this->service = $service;
        $this->securityService = $securityService;
    }
    public function exibirInicio()
    {
        $numerosPrimos = array ( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

        if ($this->securityService->isAllowed() &&
            $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["frmFuncao"] == "IncluirVariosSorteio") {
            $this->service->inserirVariosSorteios($_REQUEST);
        }
    
        if ($this->securityService->isAllowed() && @isset($_GET["excluir"]) && @is_numeric($_GET["excluir"]))
        {
            $cdJogo = $_GET["excluir"];
            echo "<p>Excluindo sorteio $cdJogo .</p>";
            $result = $this->service->excluirSorteio($cdJogo);
            if ($result) {
                echo "<p>Jogo $cdJogo eliminado.</p>";
            }
        }

        $resultado = $this->service->obterResultado();

        $top10 = $this->service->obterTop10();

        $ultimos20Sorteios = $this->service->obterUltimos20Sorteios();

        $recentTop10 = $this->service->lastTop10($ultimos20Sorteios[0]['jogo'] - 10, $ultimos20Sorteios[0]['jogo']);

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/inicio.php';
    }

    public function exibirZerar()
    {
        $results = null;

        if ($this->securityService->isAllowed() && $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["frmFuncao"] == "Zerar") {
            $results = $this->service->zerar();
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/zerar.php';
    }

    public function exibirGraficos()
    {
        $ultimoSorteio = $this->service->getUltimoSorteio();
        $resumo = $this->service->obterResumoGraficos();
        $mais = $this->service->obterGraficosMais();
        $meio = $this->service->obterGraficosMeio();
        $menos = $this->service->obterGraficosMenos();
        $ultimaRepeticao = $this->service->obterGraficosUltimaRepeticao();

        if ($this->securityService->isAllowed() && $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $this->service->gerarGraficos($ultimoSorteio);
        }
    
        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/graficos.php';
    }

    public function exibirGerar()
    {
        
        ;
        $ultimoSorteio = $this->service->getUltimoSorteio();

        if ($this->securityService->isAllowed() && $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $this->service->obterGerar($ultimoSorteio);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/gerar.php';
    }

    public function exibirGerarDois()
    {
        $ultimoSorteio = $this->service->getUltimoSorteio();

        if ($this->securityService->isAllowed() && $_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST["gerar"] == "gerar") {
            $this->service->obterGerarDois();
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/gerar_2.php';
    }

    public function exibirNumeros() {
        include_once __DIR__ . '/../Views/header.php';

        $this->service->obterNumeros();

        include_once __DIR__ . '/../Views/numeros.php';
    }

    public function exibirCombinar322() {

        if($this->securityService->isAllowed() && $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 3x2x2</h2>";
            $response = $this->service->processarCombinar322($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/combinar322.php';
    }

    public function exibirCombinar222() {

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 2x2x2</h2>";
            $response = $this->service->processarCombinar222($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/combinar222.php';
    }

    public function exibirCombinar33() {

        if($this->securityService->isAllowed() && $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar") {
            echo "<h2>Combinando 3x3</h2>";
            $response = $this->service->processarCombinar33($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/combinar33.php';
    }

    public function exibirCombinar111111() {

        if($this->securityService->isAllowed() && $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar_1x1x1x1x1x1") {
            echo "<h2>Combinando 1x1x1x1x1x1</h2>";
            $response = $this->service->processarCombinar111111($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/combinar111111.php';
    }

    public function exibirCombinar1221() {

        if($this->securityService->isAllowed() && $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["frmFuncao"] == "combinar1221") {
            echo "<h2>Combinando 1x1x1x1x1x1</h2>";
            $response = $this->service->processarCombinar1221($_POST["maisoutrosmenos"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/combinar1221.php';
    }

    public function exibirJogosLimitar() {

        if($this->securityService->isAllowed() && $_SERVER["REQUEST_METHOD"] == "POST") {
            $response = $this->service->processarJogosLimitar($_POST["qtdd"]);
        }

        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/jogoslimitar.php';
    }

    public function exibirPepe() {
        include_once __DIR__ . '/../Views/header.php';
        $this->service->exibirPepe();
    }

    public function exibirInfo() {
        include_once __DIR__ . '/../Views/header.php';
        include_once __DIR__ . '/../Views/info.php';
    }
}
