<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $data = json_decode( file_get_contents( "php://input" ), true );
  $printer_id = $data["printer_id"];
  $status = $data["status"];

  $json_arr = array(
    "result" => "error",
    "printer_id" => $printer_id
  );

  require_once("./connect-to-mysql.php");
  $sql = "UPDATE printers SET status = '".$status."' WHERE printer_id = '".$printer_id."'";
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