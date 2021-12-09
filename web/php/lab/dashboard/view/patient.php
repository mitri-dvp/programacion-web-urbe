<?php
session_start();
if(!isset($_SESSION['user'])) {
  echo 'No autorizado.';
  exit();
}
include_once('../../cnx/connection.php');
include_once('../../classes/user.php');
include_once('../../utils/index.php');

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

  // Find if user exists
  $select_query = "SELECT * FROM exams WHERE patient_id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $exams = [];
  } else {
    while ($data = pg_fetch_object($select_query_result)) {
      $exams[] = $data;
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
    <h3 class="title">Exámenes de <?= $patient->name ?></h3>
    <div class="exams">
    <?php if($user->role === 'doctor/a') { ?>
      <div class="item header lg">
        <span>Doctor</span>
        <span>Tipo de Examen</span>
        <span>Estado</span>
        <span></span>
      </div>
    <?php if (count($exams) === 0) { ?>
      <span>Sin Solicitudes.</span>
    <?php } ?> 
    <?php for ($i=0; $i < count($exams); $i++) { ?>
      <div class="item lg">
        <span><?= $exams[$i]->doctor_id ?></span>
        <span><?= id_to_type($exams[$i]->type_id) ?></span>
        <span><?= id_to_state($exams[$i]->state_id) ?></span>
        <a href="../edit/exam.php?patient_id=<?= $patient->id ?>&id=<?= $exams[$i]->id ?>">gestionar</a>
      </div>
    <?php } ?>
    <?php } else { ?>
      <div class="item header">
        <span>Doctor</span>
        <span>Tipo de Examen</span>
        <span>Estado</span>
      </div>
    <?php if (count($exams) === 0) { ?>
      <span>Sin Solicitudes.</span>
    <?php } ?> 
    <?php for ($i=0; $i < count($exams); $i++) { ?>
      <div class="item">
        <span><?= $exams[$i]->doctor_id ?></span>
        <span><?= id_to_type($exams[$i]->type_id) ?></span>
        <span><?= id_to_state($exams[$i]->state_id) ?></span>
      </div>
    <?php } ?>
    <?php } ?>

    </div>
    <a class="link" href="../add/exam.php?id=<?= $patient->id ?>">Registrar Solicitud</a>
    <a class="link" href="../../dashboard.php">Volver</a>
  </div>
</body>

</html>