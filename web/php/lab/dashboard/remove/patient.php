<?php
session_start();
if(!isset($_SESSION['user'])) {
  echo 'No autorizado.';
  exit();
}
include_once('../../cnx/connection.php');
include_once('../../classes/user.php');

if(isset($_GET['id']) && isset($_SESSION['user'])) {
  $id = $_GET['id'];
  $user = unserialize($_SESSION['user']);

  // Find if user exists
  $select_query = "SELECT * FROM patients WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
    echo 'Paciente no existe.';
    exit();
  } else {
    $user_exists = true;
    $patient = pg_fetch_object($select_query_result);
  }
}

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_SESSION['user'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];

  // Find if user exists
  $select_query = "SELECT * FROM patients WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
    echo 'Paciente no existe.';
    exit();
  } else {
    $user_exists = true;
    
    $delete_query = "DELETE FROM patients WHERE id='".$id."'";
    $delete_query_result = pg_query($conn, $delete_query); 

    if ($delete_query_result == true) {
      $delete_error = false;
      header('Location: '.'../../dashboard.php');
    } else {
      $delete_error = true;
    }
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
      <h3 class="title">Eliminar Paciente</h3>
      <label>
        <span>Nombre</span>
        <input type="text" name="name" value="<?= $patient->name ?>" readonly>
      </label>
      <label>
        <span>Cédula</span>
        <input type="text" name="id" value="<?= $patient->id ?>" readonly>
      </label>
      <label>
        <span>Correo</span>
        <input type="text" name="email" value="<?= $patient->email ?>" readonly>
      </label>
      <input class="submit" type="submit" value="Eliminar">
    </form>
    <?php if (isset($user_exists) && $user_exists === FALSE) {?>
      <span class="output error">
        Paciente no existe.
      </span>
    <?php
    }?>
    <?php if (isset($delete_error) && $delete_error === TRUE) {?>
      <span class="output error">
        Error al eliminar, por favor vuela a intentar.
      </span>
    <?php
    }?>
  </div>
</body>

</html>