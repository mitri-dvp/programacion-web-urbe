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
?>