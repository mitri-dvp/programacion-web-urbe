<?php

  $numero_empleados = getcwd();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Aplicación Bloc de Notas</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../assets/icon.svg">
</head>

<body>
  <div id="bloc">
    <h3 class="title">Aplicación Bloc de Notas:</h3>
    
    <hr>

    <div class="viewport">
    <?= $numero_empleados ?>
    </div>

    <hr>

    <div class=" links">
      <a href="../index.html">Volver</a>
      <a target="_blank" href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/bloc.php">Repositorio</a>
    </div>
  </div>
</body>

</html>