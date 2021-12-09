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

  // Find if user exists
  $select_query = "SELECT * FROM exams WHERE patient_id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $exams = [];
  } else {
    while ($data = pg_fetch_object($select_patients_query_result)) {
      $exams[] = $data;
    }
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
    <h3 class="title">Exámenes de <?= $patient->name ?></h3>
    <div class="patients">
    <?php if (count($exams) === 0) { ?>
      <span>Sin Solicitudes.</span>
    <?php } ?> 
    <?php for ($i=0; $i < count($exams); $i++) { ?>
      <div class="item">
      </div>
      <?php } ?>
    </div>
    <a class="link" href="../add/exam.php?id=<?= $patient->id ?>">Registrar Solicitud</a>
  </div>
</body>

</html>