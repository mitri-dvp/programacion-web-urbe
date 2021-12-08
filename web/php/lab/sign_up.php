<?php
session_start();
include_once('./cnx/connection.php');

if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['role'])) {
  $name = $_POST['name'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  echo $password_hash;

  // Verify Account Does not Exist


  // Register User
  
  // if(password_verify($password, $password_hash)) {
  //   echo 'TRUE';
  // }  
}

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
    <form class="login" action="./sign_up.php" method="POST">
      <h3 class="title">Por favor ingrese los siguientes datos</h3>
      <label>
        <span>Nombre</span>
        <input type="text" name="name" required>
      </label>
      <label>
        <span>Cédula</span>
        <input type="text" name="id" required>
      </label>
      <label>
        <span>Contraseña</span>
        <input type="password" name="password" required>
      </label>
      <label>
        <span>Rol</span>
      </label>
      <label class="radio">
        <span>Doctor/a</span>
        <input type="radio" name="role" value="doctor" required>
      </label>
      <label class="radio">
        <span>Enfermero/a</span>
        <input type="radio" name="role" value="nurse" required>
      </label>
      <input class="submit" type="submit" value="Regristrar">
    </form>
    <span class="link">¿ya tiene cuenta? <a href="./login.php">Ingresar</a></span>
  </div>
</body>

</html>