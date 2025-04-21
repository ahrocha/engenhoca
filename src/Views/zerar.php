<h1>Zerar estatísticas</h1>
<?php
if ($results) {
    echo "<p>As estatísticas foram zeradas.</p>";
}
?>
<form method="post">
  <input type="hidden" name="frmFuncao" value="Zerar">
  Clique aqui para zerar: <input type="submit" name="reset" value="reset">
</form>

