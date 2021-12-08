<?php
  include_once('../cnx/connection.php');
  include_once('../classes/response.php');

  $reset_query = "DROP TABLE IF EXISTS measurements;";
  $reset_query = $reset_query."DROP TABLE IF EXISTS wells;";
  $reset_query = $reset_query."CREATE TABLE wells(id SERIAL PRIMARY KEY,name character varying(100) NOT NULL);";
  $reset_query = $reset_query.'CREATE TABLE measurements (id SERIAL PRIMARY KEY,well_id INT NOT NULL,pressure INTEGER NOT NULL,"date" DATE NOT NULL,CONSTRAINT fk_well FOREIGN KEY(well_id) REFERENCES wells(id));';
  $reset_query = $reset_query."INSERT INTO wells (name) VALUES ('Pozo A'),('Pozo B'),('Pozo C'),('Pozo D');";
  $reset_query = $reset_query."INSERT INTO measurements (well_id, pressure, date) VALUES (1, 30, '2021-11-27'),(1, 35, '2021-11-28'),(1, 50, '2021-11-29'),(1, 40, '2021-11-30'),(1, 55, '2021-12-01'),(2, 33, '2021-11-24'),(2, 29, '2021-11-25'),(2, 47, '2021-11-26'),(3, 25, '2021-11-25'),(3, 35, '2021-11-26'),(3, 45, '2021-11-27'),(4, 37, '2021-11-29'),(4, 28, '2021-11-30'),(4, 32, '2021-12-01'),(4, 39, '2021-12-02'),(4, 40, '2021-12-04');";
    
  $reset_query_result = pg_query($conn, $reset_query); 

  if ($reset_query_result == true) {
    echo json_encode(new Response(FALSE));
  } else {
    echo json_encode(new Response(TRUE));
  }

  pg_close($conn);
?>