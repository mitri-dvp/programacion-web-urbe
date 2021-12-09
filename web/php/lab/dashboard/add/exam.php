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

  // Find all doctors
  $select_query = "SELECT * FROM users WHERE role_id = '1'";
  $select_query_result = pg_query($conn, $select_query); 

  while ($data = pg_fetch_object($select_query_result)) {
    $doctors[] = $data;
  }
}

if(isset($_POST['patient_id']) && isset($_POST['doctor_id']) && isset($_POST['type_id'])) {
  $patient_id = $_POST['patient_id'];
  $doctor_id = $_POST['doctor_id'];
  $type_id = $_POST['type_id'];
  $state_id = 1;
  $results = '';

  // Find if user exists
  $select_query = "SELECT * FROM patients WHERE id = '".$patient_id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $user_exists = false;
    echo 'Paciente no existe.';
    exit();
  } else {
    $user_exists = true;
    $insert_query = "INSERT INTO exams (patient_id, doctor_id, type_id, state_id, results) VALUES ('".$patient_id."', '".$doctor_id."', '".$type_id."', '".$state_id."', '".$results."')";
    $insert_query_result = pg_query($conn, $insert_query); 

    if ($insert_query_result == true) {
      header("Location: "."../view/patient.php?id=".$patient_id);
    } else {
      $register_error = true;
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
    <form class="login" action="./exam.php" method="POST">
      <h3 class="title">Registro de Solicitud de Exámen para <?= $patient->name ?></h3>
      <label>
        <span>Cédula</span>
        <input type="text" name="patient_id" value="<?= $patient->id ?>" readonly>
      </label>
      <label>
        <span>Doctor</span>
        <select name="doctor_id">
          <?php for ($i=0; $i < count($doctors); $i++) { ?>
            <option value="<?= $doctors[$i]->id ?>"><?= $doctors[$i]->name ?></option>
          <?php } ?>
        </select>
      </label>
      <label>
        <span>Tipo</span>
        <select name="type_id">
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