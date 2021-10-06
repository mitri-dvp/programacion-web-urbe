<?php
  $lado_a = 3;
  $lado_b = 4;

  $hipotenusa = sqrt(pow($lado_a, 2) + pow($lado_b, 2));
  
  echo '<h3>Calculo de la Hipotenusa del Triangulo</h3>';
  echo '<p>Lado A del Triangulo: ' . $lado_a, ' cm</p>';
  echo '<p>Lado B del Triangulo: ' . $lado_b, ' cm</p>';
  echo '<p>Hipotenusa del Triangulo: ' . $hipotenusa, ' cm</p>';

  echo '<a href="/index.html">Volver</a>';
?>