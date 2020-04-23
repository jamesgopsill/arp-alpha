<?php

$response_arr = array(
  "result" => "",
  "print_id" => ""
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Get the post data
  $data = json_decode( file_get_contents( "php://input" ), true );
  $response_arr["print_id"] = uniqid();

  file_put_contents("/app/gcode/".$response_arr["print_id"].".gcode", $data["gcode"]);

  require_once("./connect-to-mysql.php");

  $sql = "INSERT INTO queue 
  (
    print_id, 
    status, 
    date_added,
    email, 
    material_required, 
    material_length_required, 
    owner, 
    filename,
    gcode_flavour
  ) 
  VALUES 
  (
    '".$response_arr["print_id"]."', 
    'Queued', 
    NOW(),
    '".$data["email"]."', 
    '".$data["gcmaterial"]."', 
    '".$data["gclength"]."', 
    '".$data["owner"]."',
    '".$data["gcname"]."',
    '".$data["gcflavour"]."'
  )";

  if ($mysqli->query($sql) === TRUE) {
    $response_arr["result"] = "success";
  } else {
    $response_arr["result"] = $mysqli->error;
  }

  $mysqli->close();
} else {
  $response_arr["result"] = "error";
}

header("Content-type: application/json");
echo(json_encode($response_arr));

?>