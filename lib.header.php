<?php include "../lib/lib.html.menu.php";?>
<h1>loteria - megasena = <?php echo $_SERVER['PHP_SELF']; ?></h1>
<?php
function fnSessaoSelecionada($strNome)
{
	$strPath = "/loteria/megasena/";
	//echo $strPath.$strNome;
	if ($_SERVER['PHP_SELF'] == $strPath.$strNome)
		{echo "class=\"sessaoSelecionada\""; } 
}
?>
<div id="menu">
<ul>
<li>Gerenciar:</li>
<li><a href="inicio.php"   <?php fnSessaoSelecionada ( "inicio.php" ); ?> ><strong>incluir sorteio</strong></a> </li>
<li><a href="incluir_txt.php"   <?php fnSessaoSelecionada ( "incluir_txt.php" ); ?> ><strong>incluir txt</strong></a> </li>
<li><a href="zerar.php"    <?php fnSessaoSelecionada ( "zerar.php"); ?> ><strong>zerar estatísticas</strong></a> </li>
<li><a href="graficos.php" <?php fnSessaoSelecionada ( "graficos.php");  ?> ><strong>novas stats</strong></a> </li>
<li><a href="gerar.php"    <?php fnSessaoSelecionada ( "gerar.php");  ?> ><strong>gerar stats</strong></a> </li>
<li><a href="gerar_2.php"    <?php fnSessaoSelecionada ( "gerar_2.php");  ?> >gerar stats 2</a> </li>
<li><a href="numeros.php"  <?php  fnSessaoSelecionada ( "numeros.php");  ?> ><strong>ver stats</strong></a> </li>
</ul>
<br clear="all" />
<ul>
<li>Combinar:</li>
<li><a href="combinar321.php" <?php fnSessaoSelecionada ( "combinar321.php");  ?> > 321</a> </li>
<li><a href="combinar222.php" <?php fnSessaoSelecionada ( "combinar222.php");  ?> > <strong>222</strong></a> </li>
<li><a href="combinar132.php" <?php fnSessaoSelecionada ( "combinar132.php");  ?> > 132</a> </li>
<li><a href="combinar322.php" <?php fnSessaoSelecionada ( "combinar322.php");  ?> > 322</a> </li>
<li><a href="combinar331.php" <?php fnSessaoSelecionada ( "combinar331.php");  ?> > 331</a> </li>
<li><a href="combinar2222.php" <?php fnSessaoSelecionada ( "combinar2222.php");  ?> > 2222</a> </li>
<li><a href="combinar1221.php" <?php fnSessaoSelecionada ( "combinar1221.php");  ?> > 1221</a> </li>
</ul>
<br clear="all" />
<ul>
<li> | </li>
<li><a href="jogostodos.php" <?php fnSessaoSelecionada ( "jogostodos.php");  ?> >todos os jogos</a> </li>
<li><a href="jogoslimitar.php" <?php fnSessaoSelecionada ( "jogoslimitar.php");  ?> ><strong>limitar jogos</strong></a> </li>
<li><a href="jogoslimitar7.php" <?php fnSessaoSelecionada ( "jogoslimitar7.php");  ?> >limitar jogos de 7</a> </li>
<li><a href="jogoslimitar8.php" <?php fnSessaoSelecionada ( "jogoslimitar8.php");  ?> >limitar jogos de 8</a> </li>
<li><a href="jogosconferir.php" <?php fnSessaoSelecionada ( "jogosconferir.php");  ?> >conferir</a></li>
</ul>
</div> 
<br clear="all" />
