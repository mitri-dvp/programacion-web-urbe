<?php
  echo '<head>';
  echo '<meta charset="UTF-8">';
  echo '<title>Cálculo de la Hipotenusa del Triángulo</title>';
  echo '<link rel="stylesheet" href="../css/style.css">';
  echo '<link rel="icon" href="../assets/icon.svg">';
  echo '</head>';

  echo '<div id="hipotenusa">';
  echo '<h3>Cálculo de la Hipotenusa del Triángulo:</h3>';

  $lado_a = 3;
  $lado_b = 4;
  
  $hipotenusa = sqrt(pow($lado_a, 2) + pow($lado_b, 2));

  echo '<p>Lado A del Triangulo: <span>' . $lado_a, ' cm</span></p>';
  echo '<p>Lado B del Triangulo: <span>' . $lado_b, ' cm</span></p>';
  echo '<p>Hipotenusa del Triangulo: <span>' . $hipotenusa, ' cm</span></p>';

  echo '<div class="links">';
  echo '<a href="../index.html">Volver</a>';
  echo '<a target="_blank"href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/hipotenusa.php">Repositorio</a>';
  echo '</div>';
  
  echo '</div>';
?>