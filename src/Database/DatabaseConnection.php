<?php
    namespace App\Database;

    use PDO;
    use PDOException;

    class DatabaseConnection
    {
        private $pdo;

        public function __construct($host, $dbname, $username, $password)
        {
            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new PDOException("Erro de conexão: " . $e->getMessage());
            }
        }

        public function getConnection()
        {
            return $this->pdo;
        }
    }
