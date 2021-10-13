<?php
if (isset($_POST['longitud_lado'])) {
  $longitud_lado = $_POST['longitud_lado'];
} else {
  $longitud_lado = null;
}
$lados = 8;
$angulo_central = 360 / $lados;
$angulo_central_rad = $angulo_central * pi() / 180;
$apotema =  $longitud_lado / (2 * tan($angulo_central_rad / 2));
$area = 4 * $longitud_lado * $apotema;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Calcular el área de un octágono regular</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../assets/icon.svg">
</head>

<body>
  <div id="octagono">
    <h3 class="title">Cálculo del Área del Octágono Regular:</h3>

    <?php if ($longitud_lado !== null) { ?>
      <hr>
      <div class="results">
        <p>Longitud del Lado del Octágono: <span><?= $longitud_lado ?> cm</span></p>
        <p>Ángulo Central del Octágono: <span><?= $angulo_central ?>&deg;</span></p>
        <p>Apotema del Octágono: <span><?= number_format($apotema, 2) ?> cm</span></p>
        <p>Área del Octágono: <span><?= number_format($area, 2) ?> cm&sup2;</span></p>
      </div>
    <?php } ?>

    <hr>

    <form method="post" action="">
      <label>Introduzca la longitud del lado:</label>
      <input type="number" min="0" step="0.01" name="longitud_lado" required>
      <button type="submit">Enviar</button>
    </form>

    <hr>

    <div class=" links">
      <a href="../index.html">Volver</a>
      <a target="_blank" href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/octagono.php">Repositorio</a>
    </div>
  </div>
</body>

</html>