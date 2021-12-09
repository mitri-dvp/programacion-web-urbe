<?php
session_start();

include_once('../../cnx/connection.php');
include_once('../../classes/user.php');

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $password = $_POST['email'];

  // Find if user exists
  $select_query = "SELECT * FROM patients WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
    // No user, Register
    $insert_query = "INSERT INTO patients (id, name, email) VALUES (".$id.", '".$name."', '".$email."')";
    $insert_query_result = pg_query($conn, $insert_query); 
    $insert_query_count = pg_num_rows($insert_query_result);
    if ($insert_query_result == true) {
      header('Location: '.'../../dashboard.php');
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
  <link rel="stylesheet" href="../../../../css/style.css">
  <link rel="icon" href="../../../../assets/icon.svg">
</head>

<body>
  <div id="lab">
    <form class="login" action="./patient.php" method="POST">
      <h3 class="title">Registro de Paciente</h3>
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
      <input class="submit" type="submit" value="Registrar">
    </form>
    <?php if (isset($user_exists) && $user_exists === TRUE) {?>
      <span class="output error">
        Paciente ya existe.
      </span>
    <?php
    }?>
    <?php if (isset($register_error) && $register_error === TRUE) {?>
      <span class="output error">
        Error al registrar, por favor vuela a intentar.
      </span>
    <?php
    }?>
  </div>
</body>

</html>