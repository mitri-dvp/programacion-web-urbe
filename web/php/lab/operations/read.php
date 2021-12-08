<?php
  include_once('../cnx/connection.php');
  include_once('../classes/response.php');

  session_start();
  if(isset($_GET['subject']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $select_query = "SELECT * FROM measurements WHERE well_id = '".$id."' ORDER BY date";
    $select_query_result = pg_query($conn, $select_query); 
    $select_query_count = pg_num_rows($select_query_result);

    if ($select_query_count == 0) {
      echo json_encode(array(new stdClass()));
      exit;
    }

    while ($data = pg_fetch_object($select_query_result)) {
      $measurements[] = $data;
    }
    
    echo json_encode($measurements);
  } else {
    $select_query = "SELECT * FROM wells ORDER BY id";
    $select_query_result = pg_query($conn, $select_query); 
    
    while ($data = pg_fetch_object($select_query_result)) {
      $wells[] = $data;
    }
    
    echo json_encode($wells);
  }
  pg_close($conn);
?>