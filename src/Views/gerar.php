<form method="post">
  Clique aqui para gerar nova estatística: <input type="submit" name="gerar" value="gerar">
</form>

<?php

echo "Ultimo sorteio: ".$ultimoSorteio." <br> \n";
$dezultimos = $ultimoSorteio - 10;
