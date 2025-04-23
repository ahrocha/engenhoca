<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>teste</title>
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

        <li><a href="/">início</a></li>
        <li><a href="/numeros"   >ver stats</a> </li>
        <li><a href="/graficos"  >novas stats</a></li>
        <li><a href="/pepe"  >pepe</a></li>

        <?php if ($this->securityService->isAllowed()) { ?>
        <li><a href="/zerar"   >zerar</a></li>
        <li><a href="/gerar"    >gerar stats</a> </li>
        <li><a href="/gerar_2"    >gerar stats 2</a> </li>
        
        <li><a href="/combinar/33"  > 33</a>
        <li><a href="/combinar/322"  > 322</a>
        <li><a href="/combinar/222"  > 222</a> </li>
        <li><a href="/combinar/111111" > 111111</a> </li>
        <li><a href="/combinar/1221"  > 1221</a> </li>

        <li><a href="/jogoslimitar"  >limitar jogos</a> </li>

        <?php } ?>

</ul>

          </div>
        </div>
      </nav>


<div id="header">
  <h1>loteria - megasena = <?php echo $_SERVER['PHP_SELF']; ?></h1>
    <?php echo $_SERVER['PHP_SELF']; ?>
</div>
<br clear="all" />
