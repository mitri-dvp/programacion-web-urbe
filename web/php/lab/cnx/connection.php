<?php
// Parse URL
$db_url = parse_url(getenv("DATABASE_URL"));
$db_host = $db_url["host"];
$db_user = $db_url["user"];
$db_password = $db_url["pass"];
$db_name = substr($db_url["path"], 1);

// Connect to DB
$conn_string = "host=".$db_host." port=5432 dbname=".$db_name." user=".$db_user." password=".$db_password;
$conn = pg_connect($conn_string);

$timezone_identifier = 'America/Caracas';
date_default_timezone_set($timezone_identifier);
?>