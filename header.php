<?php

require_once __DIR__ . '/vendor/autoload.php';

$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
$log->warning('Foo');

$loteria = "megasena";

require_once "../lib/lib.db.inc.php";

require_once "funcoes.php";

$numerosPrimos = array ( 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59 );

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>teste</title>
  <link href="../lib/estilos.css" rel="stylesheet" type="text/css">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>

<body>
<div class="container">


      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div id="navbar" class="navbar-collapse collapse">

<ul class="nav navbar-nav">

        <li><a href="inicio.php"   <?php fnSessaoSelecionada ( "inicio.php" ); ?> >início</a></li>
        <li><a href="zerar.php"    <?php fnSessaoSelecionada ( "zerar.php"); ?> >zerar</a></li>
        <li><a href="graficos.php" <?php fnSessaoSelecionada ( "graficos.php");  ?> >novas stats</a></li>
        <li><a href="gerar.php"    <?php fnSessaoSelecionada ( "gerar.php");  ?> >gerar stats</a> </li>
        <li><a href="gerar_2.php"    <?php fnSessaoSelecionada ( "gerar_2.php");  ?> >gerar stats 2</a> </li>
        <li><a href="numeros.php"  <?php  fnSessaoSelecionada ( "numeros.php");  ?> >ver stats</a> </li>
        
        <li><a href="combinar33.php" <?php fnSessaoSelecionada ( "combinar33.php");  ?> > 33</a>
        <li><a href="combinar322.php" <?php fnSessaoSelecionada ( "combinar322.php");  ?> > 322</a>
        <li><a href="combinar222.php" <?php fnSessaoSelecionada ( "combinar222.php");  ?> > 222</a> </li>
        <li><a href="combinar111111.php" <?php fnSessaoSelecionada ( "combinar111111.php");  ?> > 111111</a> </li>
        <li><a href="combinar1221.php" <?php fnSessaoSelecionada ( "combinar1221.php");  ?> > 1221</a> </li>

        <li><a href="exportar.php"  <?php  fnSessaoSelecionada ( "exportar.php");  ?> >exportar</a> </li>

        <li><a href="jogoslimitar.php" <?php fnSessaoSelecionada ( "jogoslimitar.php");  ?> >limitar jogos</a> </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Todos <span class="caret"></span></a>
          <ul class="dropdown-menu">
        
        <li><a href="inicio.php"   <?php fnSessaoSelecionada ( "inicio.php" ); ?> >incluir sorteio</a></li>
        <li><a href="incluir_txt.php"   <?php fnSessaoSelecionada ( "incluir_txt.php" ); ?> >incluir txt</a></li>
        <li><a href="zerar.php"    <?php fnSessaoSelecionada ( "zerar.php"); ?> >zerar estatísticas</a></li>
        <li><a href="graficos.php" <?php fnSessaoSelecionada ( "graficos.php");  ?> >novas stats</a></li>
        <li><a href="gerar.php"    <?php fnSessaoSelecionada ( "gerar.php");  ?> >gerar stats</a> </li>
        <li><a href="gerar_2.php"    <?php fnSessaoSelecionada ( "gerar_2.php");  ?> >gerar stats 2</a> </li>
        <li><a href="numeros.php"  <?php  fnSessaoSelecionada ( "numeros.php");  ?> >ver stats</a> </li>

        <li><a href="exportar.php"  <?php  fnSessaoSelecionada ( "exportar.php");  ?> >exportar</a> </li>


            <li role="separator" class="divider"></li>

                            <li><a href="combinar321.php" <?php fnSessaoSelecionada ( "combinar321.php");  ?> > 321</a> </li>
                            <li><a href="combinar222.php" <?php fnSessaoSelecionada ( "combinar222.php");  ?> > 222</a> </li>
                            <li><a href="combinar111111.php" <?php fnSessaoSelecionada ( "combinar111111.php");  ?> > 111111</a> </li>
                            <li><a href="combinar132.php" <?php fnSessaoSelecionada ( "combinar132.php");  ?> > 132</a> </li>
                            <li><a href="combinar322.php" <?php fnSessaoSelecionada ( "combinar322.php");  ?> > 322</a> </li>
                            <li><a href="combinar331.php" <?php fnSessaoSelecionada ( "combinar331.php");  ?> > 331</a> </li>
                            <li><a href="combinar2222.php" <?php fnSessaoSelecionada ( "combinar2222.php");  ?> > 2222</a> </li>
                            <li><a href="combinar1221.php" <?php fnSessaoSelecionada ( "combinar1221.php");  ?> > 1221</a> </li>

            <li role="separator" class="divider"></li>


                            <li><a href="jogostodos.php" <?php fnSessaoSelecionada ( "jogostodos.php");  ?> >todos os jogos</a> </li>
                            <li><a href="jogoslimitar.php" <?php fnSessaoSelecionada ( "jogoslimitar.php");  ?> >limitar jogos</a> </li>
                            <li><a href="jogoslimitar7.php" <?php fnSessaoSelecionada ( "jogoslimitar7.php");  ?> >limitar jogos de 7</a> </li>
                            <li><a href="jogoslimitar8.php" <?php fnSessaoSelecionada ( "jogoslimitar8.php");  ?> >limitar jogos de 8</a> </li>
                            <li><a href="jogosconferir.php" <?php fnSessaoSelecionada ( "jogosconferir.php");  ?> >conferir</a></li>

            <li role="separator" class="divider"></li>

          </ul>
        </li>


</ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>


<div id="header">
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
    
</div><!-- /header -->
<br clear="all" />
