<?php
session_start();
if(!isset($_SESSION['user'])) {
  echo 'No autorizado.';
  exit();
}
include_once('../../cnx/connection.php');
include_once('../../classes/user.php');
include_once('../../utils/index.php');

if(isset($_GET['id']) && isset($_GET['patient_id']) && isset($_SESSION['user'])) {
  $id = $_GET['id'];
  $patient_id = $_GET['patient_id'];
  $user = unserialize($_SESSION['user']);
  $doctor_id = $user->id;

  // Find if exam exists
  $select_query = "SELECT * FROM exams WHERE id = '".$id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $exam_exists = false;
    echo 'Examen no existe.';
    exit();
  } else {
    $exam_exists = true;
    $exam = pg_fetch_object($select_query_result);
  }

  // Find if patient exists
  $select_query = "SELECT * FROM patients WHERE id = '".$patient_id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);

  if ($select_query_count == 0) {
    $exam_exists = false;
    echo 'Paciente no existe.';
    exit();
  } else {
    $exam_exists = true;
    $patient = pg_fetch_object($select_query_result);
  }
}

if(isset($_POST['id']) && isset($_POST['results']) && isset($_POST['update'])) {
  $exam_id = $_POST['id'];
  $results = $_POST['results'];
  
  $update_query = "UPDATE exams SET results='".$results."', state_id='2' WHERE id='".$exam_id."'";
  $update_query_result = pg_query($conn, $update_query); 
  
  if ($update_query_result == true) {
    $update_error = FALSE;
  } else {
    $update_error = TRUE;
  }
  
  // Find if exam exists
  $select_query = "SELECT * FROM exams WHERE id = '".$exam_id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);
  
  if ($select_query_count == 0) {
    $exam_exists = false;
    echo 'Examen no existe.';
    exit();
  } else {
    $exam_exists = true;
    $exam = pg_fetch_object($select_query_result);
  }
  
  // Find if patient exists
  $select_query = "SELECT * FROM patients WHERE id = '".$exam->patient_id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);
  
  if ($select_query_count == 0) {
    $exam_exists = false;
    echo 'Paciente no existe.';
    exit();
  } else {
    $exam_exists = true;
    $patient = pg_fetch_object($select_query_result);
  }
}
if(isset($_POST['id']) && isset($_POST['results']) && isset($_POST['mail'])) {
  $exam_id = $_POST['id'];
  $results = $_POST['results'];

  $select_query = "SELECT * FROM exams WHERE id = '".$exam_id."'";
  $select_query_result = pg_query($conn, $select_query); 
  $select_query_count = pg_num_rows($select_query_result);
  
  if ($select_query_count == 0) {
    $exam_exists = false;
    echo 'Examen no existe.';
    exit();
  } else {
    $exam_exists = true;
    $exam = pg_fetch_object($select_query_result);
  }

  require_once('../../../../vendor/autoload.php');

  $mpdf = new \Mpdf\Mpdf();
  $data = '';
  $data .= '<h1>Resultados de Examen</h1><br/>';
  $data .= '<b>Tipo</b>: '.id_to_type($exam->type_id).'<br/>';
  $data .= '<b>Resultados</b>:<br/> '.$exam->results.'<br/>';
  $mpdf->WriteHTML($data);
  $mpdf->Output('pdf.pdf', 'D');
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
      <h3 class="title">Edición de Examen</h3>
      <label>
        <span>Paciente</span>
        <input type="text" name="id" value="<?= $patient->id ?>" readonly>
      </label>
      <label>
        <span>Examen</span>
        <input type="text" name="id" value="<?= $exam->id ?>" readonly>
      </label>
      <label>
        <span>Tipo de Examen</span>
        <input type="text" value="<?= id_to_type($exam->type_id) ?>" readonly>
      </label>
      <label>
        <span>Resultados</span>
        <textarea name="results" cols="30" rows="10" required><?= $exam->results ?></textarea>
      </label>
      <input class="submit" type="submit" name="update" value="Actualizar">
      <input class="submit" type="submit" name="mail" value="Eviar PDF">
    </form>
    <?php if (isset($exam_exists) && $exam_exists === FALSE) {?>
      <span class="output error">
        Examen no existe.
      </span>
    <?php
    }?>
    <?php if (isset($update_error) && $update_error === TRUE) {?>
      <span class="output error">
        Error al actualizar, por favor vuela a intentar.
      </span>
    <?php
    }?>
  </div>
</body>

</html>