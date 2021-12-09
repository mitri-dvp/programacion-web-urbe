<?php
session_start();
include_once('./cnx/connection.php');
include_once('./classes/user.php');
include_once('./utils/index.php');

if(isset($_POST['id']) && isset($_POST['password'])) {
  $id = $_POST['id'];
  $password = $_POST['password'];

  // Find if user exists
  $select_query = "SELECT * FROM users WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
  } else {
    $user_exists = true;
    $_user = pg_fetch_object($select_query_result);
    if(password_verify($password, $_user->password)) {
      $user = new User($_user->id, $_user->name, $_user->email, id_to_role($_user->role_id));
      $_SESSION['user'] = serialize($user);
      header('Location: '.'dashboard.php');
    } else {
      $password_error = true;
    }
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
    <form class="login" method="POST">
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
    <span class="link">¿no tiene cuenta? <a href="./signup.php">Registrar</a></span>
    <?php if (isset($user_exists) && $user_exists === FALSE) {?>
      <span class="output error">
        Credenciales inválidas, por favor intente denuevo.
      </span>
    <?php
    }?>
    <?php if (isset($password_error) && $password_error === TRUE) {?>
      <span class="output error">
        Credenciales inválidas, por favor intente denuevo.
      </span>
    <?php
    }?>
  </div>
</body>

</html>