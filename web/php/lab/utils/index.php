<?php
function role_to_id($role) {
  switch ($role) {
    case 'doctor':
      return 1;
    case 'nurse':
      return 2;
    default:
      break;
  }
}

function id_to_role($id) {
  switch ($id) {
    case 1:
      return 'doctor/a';
    case 2:
      return 'enfermero/a';
    default:
      break;
  }
}

function id_to_type($id) {
  switch ($id) {
    case 1:
      return 'Examen de Sangre';
    case 2:
      return 'Perfil Tiroidero';
    case 3:
      return 'Examen de Glucosa';
    case 4:
      return 'Examen Rectal';
    case 5:
      return 'Colesterol Total';
    case 6:
      return 'Colonoscopia';
    case 7:
      return 'Audiograma';
    case 8:
      return 'Presión Arterial';
    case 9:
      return 'Densitometría Ósea';
    case 10:
      return 'Examen Ocular';
    default:
      break;
  }
}

function id_to_state($id) {
  switch ($id) {
    case 1:
      return 'pendiente';
    case 2:
      return 'listo';
    default:
      break;
  }
}
?>