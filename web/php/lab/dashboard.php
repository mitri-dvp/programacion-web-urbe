<?php
session_start();
include_once('./classes/user.php');
if (!isset($_SESSION['user'])) header('Location: '.'index.php');

$user = unserialize($_SESSION['user']);
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
    <h3 class="title">Bienvenido/a <?= $user->name ?></h3>
    <h3><?= $user->role ?></h3>
    <h1>Pacientes</h1>
    <a>Registra Pacientes</a>

  </div>
</body>

</html>