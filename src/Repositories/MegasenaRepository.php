<?php
namespace App\Repositories;

use App\Database\DatabaseConnection;
use PDO;
use PDOStatement;

class MegasenaRepository
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function obterResultadoRecente()
    {
        $stmt = $this->connection->query("SELECT * FROM tbl_SenaSorteios ORDER BY cdSorteio DESC LIMIT 10");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterSorteioEspecifico($jogo)
    {
        $strSQL = "SELECT num FROM tbl_Sena WHERE jogo = ".$jogo." ORDER BY num ";
        $stmt = $this->connection->query($strSQL);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterNumerosMaisSorteados()
    {
        //Lógica para retornar os números mais sorteados.
        return [1,2,3,4,5,6];
    }

    public function obterTop10(): array
    {
        $stmt = $this->connection->query("SELECT cd FROM tbl_SenaNum ORDER BY qtdd DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obterUltimos20Sorteios(): array
    {
        $strSQL = "SELECT * FROM (SELECT jogo FROM tbl_Sena GROUP BY jogo ORDER BY jogo DESC LIMIT 20 ) AS s ORDER BY jogo";
        $stmt = $this->connection->query($strSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastTop10($sorteioInicial = 0, $sorteioFinal = 0) {
        $strSQL = "SELECT num, COUNT(*) AS total FROM tbl_Sena WHERE jogo > $sorteioInicial and jogo < $sorteioFinal GROUP BY num ORDER BY total DESC ";
        $stmt = $this->connection->query($strSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserir($data)
    {
        if (!isset($data["jogo"]) || !isset($data["a"]) || !isset($data["b"]) || !isset($data["c"]) || !isset($data["d"]) || !isset($data["e"]) || !isset($data["f"])) {
            echo "<h1>Não cadastrou. Faltam dados.</h1>";
            print_r($data);
            echo '<hr>';
            return false;
        }
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["a"].")";
        $result = $this->connection->query($strSQL);
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["b"].")";
        $result = $this->connection->query($strSQL);
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["c"].")";
        $result = $this->connection->query($strSQL);
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["d"].")";
        $result = $this->connection->query($strSQL);
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["e"].")";
        $result = $this->connection->query($strSQL);
        $strSQL = "INSERT INTO tbl_Sena (jogo, num) VALUES (".$data["jogo"].",".$data["f"].")";
        $result = $this->connection->query($strSQL);
    }

    public function excluirSorteio($cdJogo)
    {
        $strSQL = "DELETE FROM tbl_Sena WHERE jogo = ".$cdJogo." LIMIT 6";
        $result = $this->connection->query($strSQL);
        if ($result) {
            return true;
        }
        return false;
    }

    public function zerar()
    {
        // $strSQL = "TRUNCATE TABLE tbl_Sena";
        // $result1 = $this->connection->query($strSQL);
        $strSQL = " TRUNCATE TABLE `tbl_SenaJogos` ";
        $result2 = $this->connection->query($strSQL);
        $strSQL = " TRUNCATE TABLE `tbl_SenaJogos7` ";
        $result3 = $this->connection->query($strSQL);
        $strSQL = " TRUNCATE TABLE `tbl_SenaJogos8` ";
        $result4 = $this->connection->query($strSQL);

        if ($result2 && $result3 && $result4) {
            return true;
        }
        return false;
    }

    public function getUltimoSorteio()
    {
        try {
            $strSQL = "SELECT jogo FROM tbl_Sena ORDER BY jogo DESC LIMIT 1";
            $stmt = $this->connection->query($strSQL);
            $return = $stmt->fetch(PDO::FETCH_ASSOC);
            return $return["jogo"];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}