<?php
  include_once('../cnx/connection.php');
  include_once('../classes/response.php');

  if(isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    
    // WELLS
    if($subject === 'wells') {      
      $id = $_POST['id'];
      $name = $_POST['name'];

      $update_query = "UPDATE wells SET name='".$name."' WHERE id='".$id."'";
      $update_query_result = pg_query($conn, $update_query); 

      if ($update_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }

    // MEASUREMENTS
    if($subject === 'measurements') {   
      $pressure = $_POST['pressure'];
      $date = $_POST['date'];
      $id = $_POST['id'];

      $update_query = "UPDATE measurements SET pressure='".$pressure."', date='".$date."' WHERE id='".$id."'";
      $update_query_result = pg_query($conn, $update_query); 

      if ($update_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }
  }
  pg_close($conn);
?>