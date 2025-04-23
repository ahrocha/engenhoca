<?php

namespace App\Core;

use App\Controllers\MegasenaController;
use App\Repositories\MegasenaRepository;
use App\Services\MegasenaService;
use App\Services\SecurityService;
use PDO;

class SimpleContainer implements ContainerInterface
{
    private array $services = [];

    public function __construct()
    {
        $this->services = [
            MegasenaController::class => function (SimpleContainer $container) {
                return new MegasenaController(
                    $container->get(MegasenaService::class),
                    $container->get(SecurityService::class)
                );
            },
            MegasenaService::class => function (SimpleContainer $container) {
                return new MegasenaService(
                    $container->get(MegasenaRepository::class),
                );
            },
            SecurityService::class => function () {
                return new SecurityService();
            },
            // MegasenaRepository::class => function (SimpleContainer $container) {
            //     return new MegasenaRepository(
            //         $container->get(PDO::class)
            //     );
            // },
            MegasenaRepository::class => function (SimpleContainer $container) {
                return new MegasenaRepository(
                    $container->get(PDO::class),
                );
            },
            // HealthController::class => function (SimpleContainer $container) {
            //     return new HealthController(
            //         $container->get(HealthService::class)
            //     );
            // },
            // HealthService::class => function ($container) {
            //     return new HealthService($container->get(PDO::class));
            // },
            PDO::class => function () {
                return DatabaseService::getConnection();
            },
        ];
    }

    public function get(string $id)
    {
        if (!isset($this->services[$id])) {
            throw new \Exception("'{$id}' não encontrado no contêiner.");
        }

        $factory = $this->services[$id];
        return $factory($this);
    }
}
