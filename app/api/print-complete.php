<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $data = json_decode( file_get_contents( "php://input" ), true );
  $printer_id = $data["printer_id"];
  $print_id = $data["print_id"];

  $json_arr = array(
    "result" => "error",
    "printer_id" => $printer_id
  );

  require_once("./connect-to-mysql.php");

  // Will need to add checks in one day so you can override an already selected print

  $sql = "UPDATE queue SET status = 'Complete', date_printed=NOW() WHERE print_id = '".$print_id."'";
  if ($mysqli->query($sql) === TRUE) {
    $json_arr["result"] = "success";
  } else {
    $json_arr["result"] = $mysqli->error;
  }
  $mysqli->close();

  header("Content-type: application/json");
  $json = json_encode($json_arr);
  echo($json);

}

?>