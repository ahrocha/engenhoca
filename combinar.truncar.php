<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["f"] == "apagar"){
    $strSQL = " TRUNCATE tbl_SenaJogos ";
    $result = $conn->query($strSQL);
    if ($result) {
        echo "Jogos apagados com sucesso.";
    } else {
        echo "Erro ao apagar jogos.";
    }
}

?>

<form method="post">
  <p>Clique para apagar todos os jogos gerados.
    <input name="f" type="submit" value="apagar">
  </p>
</form>
