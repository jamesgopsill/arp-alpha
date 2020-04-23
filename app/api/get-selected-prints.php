<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $data = json_decode( file_get_contents( "php://input" ), true );
  $printer_id = $data["printer_id"];

  $json_arr = array(
    "result" => "error",
    "printer_id" => $printer_id,
    "queue" => "",
  );

  require_once("./connect-to-mysql.php");
  $sql = "SELECT printer_id FROM printers WHERE printer_id = '".$printer_id."' ";
  if ($result = $mysqli->query($sql)) {
    if ($result->num_rows == 1) {
      // The printer exists in the array
      $sql = "SELECT * FROM queue WHERE status='Selected' AND printer_id = '".$printer_id."' "; 
      if ($queue = $mysqli->query($sql)) {
        //echo($result->num_rows);
        // Fetch all
        $rows = array();
        while ($row = $queue->fetch_assoc()) {
          array_push($rows, $row);
        }
        $json_arr["result"] = "success";
        $json_arr["queue"] = $rows;
      }
    }
  }
  $mysqli->close();

  header("Content-type: application/json");
  $json = json_encode($json_arr);
  echo($json);
}


?>