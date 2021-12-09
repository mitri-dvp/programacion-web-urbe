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
    <form class="login" action="./patient .php" method="POST">
      <h3 class="title">Registro de Solicitud de Exámen para <?= $patient->name ?></h3>
      <label>
        <span>Cédula</span>
        <input type="text" name="id" value="<?= $patient->id ?>" readonly>
      </label>
      <label>
        <span>Tipo</span>
        <select name="type">
          <option value="1">Examen de Sangre</option>
          <option value="2">Perfil Tiroidero</option>
          <option value="3">Examen de Glucosa</option>
          <option value="4">Examen Rectal</option>
          <option value="5">Colesterol Total</option>
          <option value="6">Colonoscopia</option>
          <option value="7">Audiograma</option>
          <option value="8">Presión Arterial</option>
          <option value="9">Densitometría Ósea</option>
          <option value="10">Examen Ocular</option>
        </select>
      </label>
      <input class="submit" type="submit" value="Solicitar">
    </form>
    <?php if (isset($register_error) && $register_error === TRUE) {?>
      <span class="output error">
        Error al registrar, por favor vuela a intentar.
      </span>
    <?php
    }?>
  </div>
</body>

</html>