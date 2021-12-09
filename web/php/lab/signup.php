<?php
session_start();
include_once('./cnx/connection.php');
include_once('./classes/user.php');
include_once('./utils/index.php');

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['role'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $_role = $_POST['role'];
  $role = role_to_id($_role);
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // Find if user exists
  $select_query = "SELECT * FROM users WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
    // No user, Register
    $insert_query = "INSERT INTO users (id, name, password, email, role_id) VALUES (".$id.", '".$name."', '".$password_hash."', '".$email."', '".$role."')";
    $insert_query_result = pg_query($conn, $insert_query); 
    $insert_query_count = pg_num_rows($insert_query_result);
    if ($insert_query_result == true) {
      $user = new User($id, $name, $email, id_to_role($role));
      $_SESSION['user'] = serialize($user);
      $register_error = false;
      header('Location: '.'dashboard.php');
    } else {
      $register_error = true;
    }
  } else {
    $user_exists = true;
  }
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
    <form class="login" action="./signup.php" method="POST">
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
        <span>Correo</span>
        <input type="email" name="email" required>
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
      <input class="submit" type="submit" value="Registrar">
    </form>
    <span class="link">¿ya tiene cuenta? <a href="./login.php">Ingresar</a></span>
    <?php if (isset($user_exists) && $user_exists === TRUE) {?>
      <span class="output error">
        Usuario ya existe, por favor ingrese.
      </span>
    <?php
    }?>
    <?php if (isset($register_error) && $register_error === TRUE) {?>
      <span class="output error">
        Error al registrarse, por favor vuela a intentar.
      </span>
    <?php
    }?>
  </div>
</body>

</html>