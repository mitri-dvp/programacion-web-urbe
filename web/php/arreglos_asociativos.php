<?php
$numero_empleados = 3;
if (isset($_POST['empleados'])) {
  $empleados = $_POST['empleados'];
} else {
  $empleados = null;
}
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
  <div id="arreglos_asociativos">
    <h3 class="title">Programa de Arreglos Asociativos:</h3>

    <?php if ($empleados !== null) { ?>
      <div class="results">
        <?php for ($i = 0; $i < $numero_empleados; $i++) { ?>
          <hr>
          <p>Empleado: <span><?= $empleados[$i]['nombre'] ?> <?= $empleados[$i]['apellido'] ?></span></p>
          <p>C.I.: <span><?= number_format($empleados[$i]['cedula']) ?></span></p>
          <p>Sueldo: <span>Bs. <?= number_format($empleados[$i]['sueldo'], 2) ?></span></p>
          <p>Departamento: <span><?= $empleados[$i]['departamento'] ?></span></p>
          <p>Lugar de Trabajo: <span><?= $empleados[$i]['lugar'] ?></span></p>
        <?php } ?>
      </div>
      <a class="restart" href="./arreglos_asociativos.php">Reiniciar</a>
    <?php } ?>

    <?php if ($empleados === null) { ?>
      <form method="post" action="">
        <?php for ($i = 0; $i < $numero_empleados; $i++) { ?>
          <hr>
          <h4>Empleado <?= $i + 1 ?></h4>
          <div class="row">
            <label>
              Introduzca el nombre:
              <input type="text" name="empleados[<?= $i ?>][nombre]" required>
            </label>
            <label>
              Introduzca el apellido:
              <input type="text" name="empleados[<?= $i ?>][apellido]" required>
            </label>
          </div>
          <div class="row">
            <label>
              Introduzca la cédula:
              <input type="number" name="empleados[<?= $i ?>][cedula]" min="0" required>
            </label>
            <label>
              Introduzca el sueldo:
              <input type="number" name="empleados[<?= $i ?>][sueldo]" min="0" required>
            </label>
          </div>
          <div class="row">
            <label>
              Introduzca el departamento:
              <input type="text" name="empleados[<?= $i ?>][departamento]" required>
            </label>
            <label>
              Introduzca el lugar de trabajo:
              <input type="text" name="empleados[<?= $i ?>][lugar]" required>
            </label>
          </div>
        <?php } ?>
        <button type="submit">Enviar</button>
      </form>
    <?php } ?>

    <hr>

    <div class=" links">
      <a href="../index.html">Volver</a>
      <a target="_blank" href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/arreglos_asociativos.php">Repositorio</a>
    </div>
  </div>
</body>

</html>