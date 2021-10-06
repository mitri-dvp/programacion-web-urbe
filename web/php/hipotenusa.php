<?php
  echo '<link rel="stylesheet" href="../css/style.css">';
  echo '<div id="hipotenusa">';

  $lado_a = 3;
  $lado_b = 4;

  $hipotenusa = sqrt(pow($lado_a, 2) + pow($lado_b, 2));
  
  echo '<h3>Cálculo de la Hipotenusa del Triángulo:</h3>';

  echo '<p>Lado A del Triangulo: <span>' . $lado_a, ' cm</span></p>';
  echo '<p>Lado B del Triangulo: <span>' . $lado_b, ' cm</span></p>';
  echo '<p>Hipotenusa del Triangulo: <span>' . $hipotenusa, ' cm</span></p>';

  echo '<div class="links">';
  echo '<a href="../index.html">Volver</a>';
  echo '<a target="_blank"href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/hipotenusa.php">Repositorio</a>';
  echo '</div>';
  
  echo '</div>';
?>