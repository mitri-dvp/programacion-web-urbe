<?php
$lado_a = 3;
$lado_b = 4;

$hipotenusa = sqrt(pow($lado_a, 2) + pow($lado_b, 2));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Cálculo de la Hipotenusa del Triángulo</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../assets/icon.svg">
</head>

<body>
  <div id="hipotenusa">
    <h3 class="title">Cálculo de la Hipotenusa del Triángulo:</h3>

    <div class="results">
      <p>Lado A del Triangulo: <span><?= $lado_a ?> cm</span></p>
      <p>Lado B del Triangulo: <span><?= $lado_b ?> cm</span></p>
      <p>Hipotenusa del Triangulo: <span><?= $hipotenusa ?> cm</span></p>
    </div>

    <div class="links">
      <a href="../index.html">Volver</a>
      <a target="_blank" href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/hipotenusa.php">Repositorio</a>
    </div>
  </div>
</body>

</html>