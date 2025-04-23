<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class DatabaseService
{
    public static ?PDO $connection = null;
    private static ?Logger $logger = null;

    private static function initializeLogger(): void
    {
        if (self::$logger === null) {
            self::$logger = new Logger('database');
            self::$logger->pushHandler(new StreamHandler('php://stdout', Logger::WARNING));
        }
    }

    public static function getConnection(): PDO
    {
        if (!self::$connection) {
            self::initializeLogger();
            $host = $_ENV['ENGENHOCA_DB_HOST'] ?? 'localhost';
            $db   = $_ENV['ENGENHOCA_DB_NAME'] ?? 'engenhoca';
            $user = $_ENV['ENGENHOCA_DB_USER'] ?? 'engenhoca';
            $pass = $_ENV['ENGENHOCA_DB_PASS'] ?? 'engenhoca';

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                self::$logger->error('Erro ao conectar com o banco de dados: ' . $e->getMessage());
                echo "Erro ao conectar com o banco de dados: ";
                die();
            }
        }

        return self::$connection;
    }
}