<?php

require_once __DIR__ . '/../vendor/autoload.php';

$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::WARNING));
$log->info('Acesso');

$loteria = "megasena";

$numerosPrimos = array ( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

use Bramus\Router\Router;
use App\Core\SimpleContainer;
use App\Controllers\MegasenaController;

$router = new Router();
$container = new SimpleContainer();

$router->get('/', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirInicio();
});

$router->match('GET|POST', '/zerar', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirZerar();
});


$router->match('GET|POST', '/graficos', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirGraficos();
});

$router->match('GET|POST', '/gerar', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirGerar();
});

$router->match('GET|POST', '/gerar_2', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirGerarDois();
});

$router->match('GET|POST', '/numeros', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirNumeros();
});

$router->match('GET|POST', '/pepe', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirPepe();
});

$router->match('GET|POST', '/combinar/33', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirCombinar33();
});

$router->match('GET|POST', '/combinar/222', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirCombinar222();
});

$router->match('GET|POST', '/combinar/322', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirCombinar322();
});

$router->match('GET|POST', '/combinar/111111', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirCombinar111111();
});

$router->match('GET|POST', '/combinar/1221', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirCombinar1221();
});

$router->match('GET|POST', '/jogoslimitar', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirJogosLimitar();
});

$router->match('GET|POST', '/pepe', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirPepe();
});

$router->match('GET|POST', '/info', function () use ($container) {
    $controller = $container->get(MegasenaController::class);
    $controller->exibirInfo();
});

$router->set404(function () {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);
});

$router->run();
