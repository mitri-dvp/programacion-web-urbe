<?php
  include_once('../cnx/connection.php');
  include_once('../classes/response.php');

  if(isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    
    // WELLS
    if($subject === 'wells') {      
      $name = $_POST['name'];

      $insert_query = "INSERT INTO wells (name) VALUES ('".$name."')";
      $insert_query_result = pg_query($conn, $insert_query); 

      if ($insert_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }

    // MEASUREMENTS
    if($subject === 'measurements') {   
      $well_id = $_POST['well_id'];
      $pressure = $_POST['pressure'];
      $date = $_POST['date'];
      
      $insert_query = "INSERT INTO measurements (well_id, pressure, date) VALUES ('".$well_id."', '".$pressure."', '".$date."')";

      $insert_query_result = pg_query($conn, $insert_query); 

      if ($insert_query_result == true) {
        echo json_encode(new Response(FALSE));
      } else {
        echo json_encode(new Response(TRUE));
      }
    }
  }
  pg_close($conn);
?>