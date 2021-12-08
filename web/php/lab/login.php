<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Programa para Laboratorio</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="icon" href="../../assets/icon.svg">
</head>

<body>
  <div id="lab">
    <form class="login">
      <h3 class="title">Por favor ingrese sus datos</h3>
      <label>
        <span>Cédula</span>
        <input type="text" name="id" required>
      </label>
      <label>
        <span>Contraseña</span>
        <input type="password" name="password" required>
      </label>
      <input class="submit" type="submit" value="Ingresar">
    </form>
    <span class="link">¿no tiene cuenta? <a href="./sign_up.php">Registrar</a></span>
  </div>
</body>

</html>