<?php
session_start();

if (!isset($_SESSION['user'])) header('Location: '.'index.php');

include_once('./cnx/connection.php');
include_once('./classes/user.php');
include_once('./utils/index.php');

$user = unserialize($_SESSION['user']);

// Fetch Patients
$select_patients_query = "SELECT * FROM patients";
$select_patients_query_result = pg_query($conn, $select_patients_query); 
while ($data = pg_fetch_object($select_patients_query_result)) {
  $patients[] = $data;
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
    <h3 class="title">Bienvenido</h3>
    <div class="user">
      <div class="item header">
        <span>Cedula</span>
        <span>Nombre</span>
        <span>Correo</span>
        <span>Rol</span>
      </div>
      <div class="item">
        <span><?= $user->id ?></span>
        <span><?= $user->name ?></span>
        <span><?= $user->email ?></span>
        <span><?= $user->role ?></span>
      </div>
    </div>
    <h3 class="title">Pacientes</h1>
    <div class="patients">
      <div class="item header">
        <span class="name">Nombre</span>
        <span class="name">Correo</span>
      </div>
      <?php for ($i=0; $i < count($patients); $i++) { ?>
      <div class="item">
        <span class="name"><?= $patients[$i]->name ?></span>
        <span class="name"><?= $patients[$i]->email ?></span>
        <a href="./dashboard/edit/patient.php?id=<?= $patients[$i]->id ?>">editar</a>
        <a href="./dashboard/remove/patient.php?id=<?= $patients[$i]->id ?>">borrar</a>
        <a href="./dashboard/view/patient.php?id=<?= $patients[$i]->id ?>">ver exámenes</a>
      </div>
      <?php } ?> 
    </div>
    <a class="link" href="./dashboard/add/patient.php">Registrar Paciente</a>
    <a class="link" href="./logout.php">Cerrar Sesion</a>
    <a class="link" href="./operations/reset.php">Restablecer</a>

  </div>
</body>

</html>