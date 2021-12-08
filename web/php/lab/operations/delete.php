<?php
  include_once('../cnx/connection.php');
  include_once('../classes/response.php');

  if(isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    
    // WELLS
    if($subject === 'wells') {      
      $id = $_POST['id'];

      $delete_query = "DELETE FROM wells WHERE id='".$id."'";
      $delete_query_result = pg_query($conn, $delete_query); 

      if ($delete_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }

    // MEASUREMENTS
    if($subject === 'measurements') {   
      $id = $_POST['id'];

      $delete_query = "DELETE FROM measurements WHERE id='".$id."'";
      $delete_query_result = pg_query($conn, $delete_query); 

      if ($delete_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }
  }
  pg_close($conn);
?>